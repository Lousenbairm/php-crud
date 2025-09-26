<?php
// require('../src/database.php');
// $pdo=connectDB();
//Can pass through require in index


function getPagination(PDO $pdo) {
    
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $rowCount = 10;
    $offset = ($currentPage * $rowCount)-$rowCount;
    $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
    $searchQuery = '';

    
    $prepCountQuery='
    SELECT COUNT(*) FROM `crud_proj`.`customer`;
    ';

    if($searchTerm) {

    } else {

    }

    $prepQuery='
    SELECT * FROM `crud_proj`.`customer` 
    WHERE 1=1
    and deleted_at IS NULL
    ORDER BY updated_at DESC LIMIT :limit OFFSET :offset;
    ';
    
    try {
        
        $queryData = $pdo->prepare($prepQuery);
        $queryData->bindParam(':limit', $rowCount, PDO::PARAM_INT);
        $queryData->bindParam(':offset', $offset, PDO::PARAM_INT);
        $queryData->execute();
        $customersData = $queryData->fetchAll(PDO::FETCH_ASSOC);

        $queryItemCount = $pdo->prepare($prepCountQuery);
        $queryItemCount->execute();
        $itemCount = $queryItemCount->fetchColumn();
        
        
        return [
            'customers' => $customersData,
            'currentPage' => $currentPage,
            'itemCount' => $itemCount,
            'totalPage' => ceil($itemCount/$rowCount),
            'offset' => $offset
        ];

    } catch(PDOException $e) {
        echo "Reading failed," . $e->getMessage();
    }
}

?>