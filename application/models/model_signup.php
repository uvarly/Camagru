<?php

class Model_Signup extends Model {
    public function __construct() {
    }
    
    public function insert_user() {
        require 'config/database.php';

        if (!isset($_POST['login']) || empty($_POST['login'])) {
            return 'bad_login';
        }

        if (!isset($_POST['passw']) || empty($_POST['passw'])) {
            return 'bad_passw';
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return 'bad_email';
        }

        $result = check_user()

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`) VALUES (?, ?, ?, ?)';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($login, $passw, $email, $image));

        return $sth;
    }

    private function check_user($args)
    {

    }
}