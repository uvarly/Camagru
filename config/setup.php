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
        `User_ID` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `Login` VARCHAR(32) NOT NULL,
        `Password` VARCHAR(256) NOT NULL,
        `Email` VARCHAR(32) NOT NULL,
        `Image` VARCHAR(32),
        `Confirmed` BOOLEAN DEFAULT 0 NOT NULL,
        `Send_Mail` BOOLEAN DEFAULT 1 NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `Posts`
    (
        `Post_ID` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `User_ID` INT UNSIGNED NOT NULL,
        `Image` VARCHAR(32) NOT NULL,
        `Message` VARCHAR(128),
        `Likes` INT UNSIGNED DEFAULT 0 NOT NULL,
        `Creation_Date` DATETIME DEFAULT NOW() NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `Comments`
    (
        `Comment_ID` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `User_ID` INT UNSIGNED NOT NULL,
        `Post_ID` INT UNSIGNED NOT NULL,
        `Message` VARCHAR(128) NOT NULL,
        `Creation_Date` DATETIME DEFAULT NOW() NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `Likes`
    (
        `User_ID` INT UNSIGNED NOT NULL,
        `Post_ID` INT UNSIGNED NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `Confirmation`
    (
        `ID` VARCHAR(128) NOT NULL,
        `Login` VARCHAR(32) NOT NULL
    )');
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}