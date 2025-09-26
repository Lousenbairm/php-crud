<?php
// require('../src/database.php');
// $pdo=connectDB();
//Can pass through require in index


function getPagination(PDO $pdo, string $searchTerm = '') {
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $rowCount = 10;
    $offset = ($currentPage * $rowCount)-$rowCount;
    $baseSql = 'FROM `crud_proj`.`customer` WHERE deleted_at IS NULL ';
    $params = [];

    if (!empty($searchTerm)) {
        $baseSql .= 'AND CONCAT_WS(" ", name, nric, dob, mobile_no, address) LIKE :search ';

        $params[':search'] = '%'. $searchTerm .'%'; 
    }
    
    $prepCountQuery='
    SELECT COUNT(*) '. $baseSql;
    
    $prepQuery='
    SELECT * '. $baseSql .' ORDER BY updated_at DESC LIMIT :limit OFFSET :offset;
    ';
    
    try {
        
        
        $queryData = $pdo->prepare($prepQuery);
        if (!empty($searchTerm)) {
        $queryData->bindParam(':search', $params[':search'], PDO::PARAM_STR);

        }
        $queryData->bindParam(':limit', $rowCount, PDO::PARAM_INT);
        $queryData->bindParam(':offset', $offset, PDO::PARAM_INT);
        $queryData->execute();
        $customersData = $queryData->fetchAll(PDO::FETCH_ASSOC);

        $queryItemCount = $pdo->prepare($prepCountQuery);
        $queryItemCount->execute($params);
        $itemCount = $queryItemCount->fetchColumn();
        
        
        return [
            'customers' => $customersData,
            'currentPage' => $currentPage,
            'itemCount' => $itemCount,
            'totalPage' => ceil($itemCount/$rowCount),
            'offset' => $offset,
        ];

    } catch(PDOException $e) {
        echo "Reading failed," . $e->getMessage();
    }
}

?>