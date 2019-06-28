<?php

class Model_Signup extends Model
{
    public function __construct()
    {
    }
    
    public function insert_user($login, $passw, $email, $image)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`) VALUES ('$login', '$passw', '$email', '$image')");
    }
}