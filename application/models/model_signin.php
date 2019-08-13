<?php

class Model_Signin extends Model {
    public function __construct() {
    }
    
    public function signin_user() {
        if (!isset($_POST['login']) || empty($_POST['login']))
            return 'bad_login';

        if (!isset($_POST['passw']) || empty($_POST['passw']))
            return 'bad_passw';

        if (!isset($_POST['submit']) || $_POST['submit'] != 'OK')
            return 'bad_submit';

        $login = $_POST['login'];
        $passw = hash('whirlpool', $_POST['passw']);

        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `User_ID`, `Login`, `Password`, `Confirmed` FROM `Users` WHERE `Login` = ? AND `Password` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($login, $passw));

        $result = $sth->fetchAll();
        foreach ($result as $match)
        {
            if ($login == $match['Login'] && $passw == $match['Password'])
            {
                $_SESSION['Logged_user'] = $login;
                $_SESSION['Logged_user_ID'] = $match['User_ID'];
                $_SESSION['Session_ID'] = hash('whirlpool', $match['User_ID'] . $login);
                $_SESSION['Confirmed'] = $match['Confirmed'];
                return 'success';
            }
        }        
        return 'fail';
    }
}