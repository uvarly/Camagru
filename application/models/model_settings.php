<?php

class Model_Main extends Model {

    public function change_image() {
        if (empty($_FILES) || !is_uploaded_file($_FILES['profile_image']['tmp_name']))
            return 'no_image';

        $result = $this->_upload_file();
        if ($result == 'forbidden_image_type')
            return $result;

        $this->_update_user_table();
    }
    
    public function change_notifications() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $set = $_POST['notifications'] == "Enable" ? 1 : 0;

        $sql = 'UPDATE `Users` SET `Send_Mail` = ? WHERE `User_ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($set, $_SESSION['Logged_user_ID']));
    }

    public function change_login() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        if (!isset($_POST['login']) || empty($_POST['login']))
            return 'bad_login';

        $new_login = $_POST['login'];

        if (!$this->_check_login($new_login))
            return 'login_exists';
        
        $sql = 'UPDATE `Users` SET `Login` = ? WHERE `User_ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($new_login, $_SESSION['Logged_user_ID']));

        $_SESSION = array();
        header('Location: /');
    }

    public function change_email() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        if (!isset($_POST['email']) || empty($_POST['email']))
            return 'no_email';

        $new_email = $_POST['email'];

        if (!$this->_check_email($new_email))
            return 'email_exists';
        
        $sql = 'UPDATE `Users` SET `Email` = ? WHERE `User_ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($new_email, $_SESSION['Logged_user_ID']));

        $_SESSION = array();
        header('Location: /');
    }

    public function change_password() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        if (!isset($_POST['passw']) || empty($_POST['passw']))
            return 'no_passw';

        if ($_POST['passw'] == strtolower($_POST['passw']) || strlen($_POST['passw']) <= 7)
            return 'weak_passw';

        $new_passw = hash('whirlpool', $_POST['passw']);

        $sql = 'UPDATE `Users` SET `Password` = ? WHERE `User_ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($new_passw, $_SESSION['Logged_user_ID']));

        $_SESSION = array();
        header('Location: /');
    }

    private function _upload_file() {
        require 'config/ftp.php';

        $user = $_SESSION['Logged_user'];
        $user_id = $_SESSION['Logged_user_ID'];
        $filename = hash('crc32', $user);

        $type = exif_imagetype($_FILES['profile_image']['tmp_name']);

        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($_FILES['profile_image']['tmp_name']);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($_FILES['profile_image']['tmp_name']);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($_FILES['profile_image']['tmp_name']);
                break;
            default:
                return 'forbidden_image_type';
        }

        $ftp = ftp_connect($FTP_HOST);
        ftp_login($ftp, $FTP_USER, $FTP_PASS);
        
        $image_list = ftp_nlist($ftp, "/user_profile_images/$filename.jpg");

		if (in_array("/user_profile_images/$filename.jpg", $image_list))
            ftp_delete($ftp, "/user_profile_images/$filename.jpg");
            
        imagejpeg($image, $FTP_CONN . "user_profile_images/$filename.jpg");
    }

    private function _update_user_table() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $filename = hash('crc32', $_SESSION['Logged_user']);

        $sql = 'UPDATE `Users` SET `Image` = ? WHERE `User_ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($filename . '.jpeg', $_SESSION['Logged_user_ID']));
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