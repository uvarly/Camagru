<?php

require 'database.php';

try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS camagru_db');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `Users`
    (
        `User_ID` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `Login` VARCHAR(32) NOT NULL,
        `Password` VARCHAR(32) NOT NULL,
        `Email` VARCHAR(32) NOT NULL,
        `Image` VARCHAR(32) DEFAULT "noimg" NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `Posts`
    (
        `Post_ID` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        `User_ID` INT NOT NULL,
        `Image` VARCHAR(32) NOT NULL,
        `Message` VARCHAR(128) NOT NULL,
        `Creation_Date` DATETIME DEFAULT NOW() NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

// try {
//     $pdo->exec('CREATE TABLE IF NOT EXISTS `Comments`
//     (
//         `User_ID` INT PRIMARY KEY NOT NULL,
//         `Post_ID` INT NOT NULL,
//         `Comment_ID` INT NOT NULL,
//         `Message` VARCHAR(128) NOT NULL,
//         `Creation_Date` DATETIME DEFAULT NOW() NOT NULL
//     )');
// } catch (Exception $exc) {
//     die ("Exception caught: " . $exc->getMessage());
// }