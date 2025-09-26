<?php
session_start();
require('../src/database.php');
$pdo=connectDB();

$prepQuery = $pdo->prepare('
    INSERT INTO `crud_proj`.`customer` (nric, name, dob, address, mobile_no) VALUES (:nric, :name, :dob, :address, :mobile_no);
');


    if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['search'])) {
        $name = $_POST['name'];
        $nric = $_POST['nric'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $mobile_no = $_POST['mobile_no'];

        if (!ctype_digit($nric) || !ctype_digit($mobile_no)) {
        
            $_SESSION['query_status'] = 'Error: NRIC and Mobile Number must contain only numbers.';
        }

        try {
            $prepQuery->execute([
                ':name'=>$name,
                ':nric'=>$nric,
                ':dob'=>$dob,
                ':address'=>$address,
                ':mobile_no'=>$mobile_no
            ]);
            $_SESSION['query_status'] = 'Data insert successfully...';
            header('Location: index.php');
            exit;

        } catch(PDOException $e) {
            $_SESSION['query_status'] = "Inserting failed," . $e->getMessage();
            header('Location: index.php');
            exit;
        }

        
    } else {
        header('Location: index.php');
        exit;
    }
?>