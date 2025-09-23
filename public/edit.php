<?php
session_start();
require('../src/database.php');
$pdo=connectDB();

$nric = filter_input(INPUT_GET, 'nric');

//Show initial customer data
if($nric) {
    try {
        $prepQuery='
            SELECT * FROM `crud_proj`.`customer` WHERE nric = :nric;
        ';
        $queryData = $pdo->prepare($prepQuery);
        $queryData->execute([
            'nric' => $nric
        ]);
        $customersData = $queryData->fetch(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Fetching data failed," . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nric = $_POST['nric'];
    $address = $_POST['address'];
    $mobile_no = $_POST['mobile_no'];


    try {
        $prepQuery='
            UPDATE `crud_proj`.`customer` SET address = :address, mobile_no = :mobile_no WHERE nric = :nric;
        ';
        $queryData = $pdo->prepare($prepQuery);
        $queryData->execute([
            'address' => $address,
            'mobile_no' => $mobile_no,
            'nric' => $nric
        ]);
        
        $_SESSION['query_status'] = 'Data edited successfully for  '. $nric .' ...';
        header('Location: index.php');
        exit;

    } catch(PDOException $e) {
        $_SESSION['query_status'] = "Fetching data failed," . $e->getMessage();
        header('Location: index.php');
        exit;
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Edit Customer Data</title>
</head>
<body>
    <h1>Edit Data for <?=$nric ?></h1>
    <form action="edit.php" method="post">
         <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value=<?= $customersData['name']?> readonly>
        </div>

        <div class="form-group">
            <label for="nric">NRIC / ID Number</label>
            <input type="text" id="nric" name="nric" value=<?= $customersData['nric']?> readonly>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value=<?= $customersData['dob']?> readonly>
        </div>

        <div class="form-group">
            <label for="mobile_no">Mobile Number</label>
            <input type="tel" id="mobile_no" name="mobile_no" value=<?= $customersData['mobile_no']?> pattern="[0-9]*" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="5" required><?= $customersData['address']?></textarea>
        </div>

        <div>
            <button type="submit" class="submit-btn">Update User</button>
        </div>
    </form>
</body>
</html>