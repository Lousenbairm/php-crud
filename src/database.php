<?php

require '../config.php';

function connectDB() {
    $dsn = "mysql:host=" . HOST . ";port=" .PORT. ";dbname=" . DATABASE . ";charset=UTF8";
    
    try {
    
        $pdo = new PDO($dsn, USER, PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
        // if($pdo) {
        //     echo "<p style='display: none;'>Connected to DB Successfully...</p>";
        // }
        //Database object should have produce any output
    
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $pdo;
}


?>