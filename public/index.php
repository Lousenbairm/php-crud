<?php
session_start();
require_once("../src/database.php");
$pdo = connectDB();
require_once("./read.php");

if(isset($_SESSION['query_status'])){
    $status = $_SESSION['query_status'];
    
    unset($_SESSION['query_status']);

} else {
    $status = '';
}


$searchTerm = '';
if (!empty($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    
} elseif (!empty($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
}

$paginationData = getPagination($pdo, $searchTerm);
$currentPage = $paginationData['currentPage'];
$totalPage = $paginationData['totalPage'];
$offset = $paginationData['offset'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>PHP BO</title>
</head>
<body>
    <div class="form-container">
        <h1>Customer Registration System</h1>
        <p>Please fill in the details below to add new customer.</p>
        
        <form action="store.php" method="post">
            <div class="form-grid">
                
                <div class="form-column">


                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="e.g., Ali" required>
                    </div>

                    <div class="form-group">
                        <label for="nric">NRIC / ID Number</label>
                        <input type="text" id="nric" name="nric" placeholder="e.g., 901231105678" pattern="[0-9]*" required>
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label for="mobile_no">Mobile Number</label>
                        <input type="tel" id="mobile_no" name="mobile_no" placeholder="e.g., 0123456789" pattern="[0-9]*" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="5" placeholder="Enter full address" required></textarea>
                    </div>

                </div>
                
                
            </div> 
            <input type="submit" class="submit-btn" name="submit-data"/>
        </form>
            
            <div class="customer-listing">
                <div class="listing-heading">
                    <h2>Customer Record</h2>
                    <form action="index.php#pagination-tab" method="POST">
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control" 
                                placeholder="Search for customers..." 
                                value="<?php echo $searchTerm; ?>"
                            >
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <table>
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>NRIC</th>
                        <th>DOB</th>
                        <th>Mobile No</th>
                        <th>Address</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                    $index = $offset+1;
                    foreach($paginationData['customers'] as $customer):
                        ?>
                <tr>
                    <td><?= $index ?></td>
                    <td><?= $customer['name']?></td>
                    <td><?= $customer['nric']?></td>
                    <td><?= $customer['dob']?></td>
                    <td><?= $customer['mobile_no']?></td>
                    <td><?= $customer['address']?></td>
                    <td>
                        <a href='delete.php?nric=<?=$customer['nric'] ?>' class="delete-link"> Delete </a>
                        <a href='edit.php?nric=<?=$customer['nric'] ?>'> Edit </a>
                    </td>
                    
                </tr>
                <?php
                    $index++;
                endforeach;
                ?>
            </tbody>
        </table>
        <div class="pagination-button" id="pagination-tab">
            <?php

            $searchQueryString = !empty($searchTerm) ? '&search=' . urlencode($searchTerm) : '';

                if($currentPage < $totalPage) {
                    $nextPage = $currentPage + 1;
                    echo "<a href='index.php?page={$nextPage}{$searchQueryString}#pagination-tab'>Next &raquo;</a>";
                } else {
                    echo "<span class='disabled'>Next &raquo;</span>";
                }

                echo "<span>{$currentPage}/{$totalPage}</span>";

                if($currentPage > 1) {
                    $previosPage = $currentPage - 1;
                    echo "<a href='index.php?page={$previosPage}{$searchQueryString}#pagination-tab'>&laquo; Previous</a>";
                } else {
                    echo "<span class='disabled'>&laquo; Previous</span>";
                }
?>
        </div>
    </div>
    <div class="status"><?= $status ?></div>
    
</body>
</html>