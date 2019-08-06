<?php

class Model_Signup extends Model {
    public function __construct() {
    }
    
    public function insert_user() {
        require 'config/database.php';
        require 'config/ftp.php';

        if (!isset($_POST['login']) || empty($_POST['login']))
            return 'bad_login';

        if (!isset($_POST['passw']) || empty($_POST['passw']) ||
                $_POST['passw'] == strtolower($_POST['passw']) || strlen($_POST['passw']) <= 7)
            return 'bad_passw';

        if (!isset($_POST['email']) || empty($_POST['email']))
            return 'bad_email';

        if (!isset($_POST['submit']) || $_POST['submit'] != 'OK')
            return 'bad_submit';

        if (!$this->_check_login($_POST['login']))
            return 'user_exists';

        if (!$this->_check_email($_POST['email']))
            return 'email_exists';

        $login = $_POST['login'];
        $passw = hash('whirlpool', $_POST['passw']);
        $email = $_POST['email'];
        $image = "noimg.jpeg";
        
        $this->_send_mail($login, $email);

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`) VALUES (?, ?, ?, ?)';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($login, $passw, $email, $image));

        $sql = 'INSERT INTO `Confirmation` (`ID`, `Login`) VALUES (?, ?)';
        $id = hash('whirlpool', $login);

        $sth = $pdo->prepare($sql);
        $sth->execute(array($id, $login));

        return 'success';
    }

    public function confirm_account($param) {
        require 'config/database.php';

        if ($this->_check_link($param[0]) == false)
            return 'bad_link';
        
        $link = $param[0];

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Login` FROM `Confirmation` WHERE `ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($link));

        $result = $sth->fetch();
        $login = $result['Login'];

        $sql = 'UPDATE `Users` SET `Confirmed` = 1 WHERE `Login` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($login));

        $sql = 'DELETE FROM `Confirmation` WHERE `Login` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($login));

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

    private function _check_link($link)
    {
        require 'config/database.php';

        if (!isset($link) || empty($link) || strlen($link) < 128)
            return false;

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `ID`, `Login` FROM `Confirmation` WHERE `ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($link));

        $result = $sth->fetchAll();

        foreach ($result as $match) {
            $login = hash('whirlpool', $match['Login']);
            if ($link != $login)
                return false;
        }

        return true;
    }

    private function _send_mail($login, $email) {
        $to      = $email;
        $subject = 'Camagru: Please confirm your account';
        $message = 'Your newly created accound requires confirmation. Follow this link: http://' . $_SERVER['HTTP_HOST'] . '/signup/confirm/' . hash('whirlpool', $login);
        $message = wordwrap($message, 70, "\r\n");
        $headers =  'From: somerussianlad@gmail.com' . "\r\n" .
                    'Reply-To: somerussianlad@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}