<?php
//create new data
require "../src/database.php";

$query = '
    CREATE TABLE IF NOT EXISTS `crud_proj`.`customer` (
    `nric` VARCHAR(12) PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `dob` DATE NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `mobile_no` VARCHAR(20) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,

    INDEX `idx_dob` (`dob`),
    INDEX `idx_delete_at` (`deleted_at`),
    INDEX `idx_mobile_no` (`mobile_no`),

    CONSTRAINT `chk_nric_format` CHECK(`nric` REGEXP `^[0-9]{12}$`)
);
';

$pdo = connectDB();

try {

    $pdo->exec($query);
    echo('Table created successfully');
    
} catch (PDOException $e) {
    echo('Create table failed,' . $e->getMessage());
}

?>