<?php

class Model_Signup extends Model {
    public function __construct() {
    }
    
    public function insert_user() {
        require 'config/database.php';
        require 'config/ftp.php';

        if (!isset($_POST['login']) || empty($_POST['login']))
            return 'bad_login';

        if (!isset($_POST['passw']) || empty($_POST['passw']))
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

        if ($_FILES['image']['error'] == 0)
        {
            $image = $_FILES['image']['tmp_name'];
            if (!$this->_check_image($image))
                return 'malicious_file';
            
                $info = exif_imagetype($image);
                $extension = image_type_to_extension($info);
                $extension = strtolower($extension);

                switch ($extension) {
                    case '.gif':
                        $image = imagecreatefromgif($_FILES['image']['tmp_name']);
                        break;
                    case '.jpeg':
                        $image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
                        break;
                    case '.png':
                        $image = imagecreatefrompng($_FILES['image']['tmp_name']);
                        break;
                }

                imagejpeg($image, $FTP_CONN . 'user_profile_images/' . hash('crc32', $login) . '.jpg');
                $image = hash('crc32', $login) . '.jpg';
        }
        else
            $image = null;

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`) VALUES (?, ?, ?, ?)';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($login, $passw, $email, $image));

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

    private function _check_image($file) {

        $image_type = exif_imagetype($file);

        switch ($image_type) {
            case IMAGETYPE_GIF:
            case IMAGETYPE_JPEG:
            case IMAGETYPE_PNG:
                return true;
                break;
            default:
                return false;
                break;
        }
    }
}