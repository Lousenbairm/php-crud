<?php
session_start();
require('../src/database.php');
$pdo=connectDB();

$nric = filter_input(INPUT_GET, 'nric');

$prepQuery = $pdo->prepare('
    UPDATE `crud_proj`.`customer` SET deleted_at = now() WHERE nric = :nric;
');



try {

    $prepQuery->execute([
        'nric'=>$nric
    ]);
    $_SESSION['query_status'] = 'Data delete '. $nric .' successfully...';
    header('Location: index.php');
    exit;

} catch(PDOException $e) {
     $_SESSION['query_status'] = "Delete failed," . $e->getMessage();
    header('Location: index.php');
    exit;
}

?>