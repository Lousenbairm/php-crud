<?php
// require('../src/database.php');
// $pdo=connectDB();
//Can pass through require in index

$prepQuery='
    SELECT * FROM `crud_proj`.`customer` WHERE deleted_at IS NULL ORDER BY updated_at DESC;
';

try {

    $queryData = $pdo->prepare($prepQuery);
    $queryData->execute();
    $customersData = $queryData->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Reading failed," . $e->getMessage();
}
?>