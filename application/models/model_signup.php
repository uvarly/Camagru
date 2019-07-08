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

        if (!$this->_check_login($_POST['login'])) {
            return 'user_exists';
        }

        if (!$this->_check_email($_POST['email'])) {
            return 'email_exists';
        }

        $login = $_POST['login'];
        $passw = hash('whirlpool', $_POST['passw']);
        $email = $_POST['email'];

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'INSERT INTO `Users` (`Login`, `Password`, `Email`) VALUES (?, ?, ?)';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($login, $passw, $email));

        return 'success';
    }

    private function _check_login($login) {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Login` FROM `Users` WHERE `Login` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($login));

        $result = $sth->fetchAll();
        foreach ($result as $match)
            if ($login == $match['Login'])
                return false;
        return true;
    }

    private function _check_email($email) {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Email` FROM `Users` WHERE `Email` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($email));

        $result = $sth->fetchAll();
        foreach ($result as $match)
            if ($email == $match['Email'])
                return false;
        return true;
    }
}