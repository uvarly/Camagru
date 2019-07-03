<?php

class Model_Profile extends Model
{
    public function get_data()
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Users`.`Login`, `Users`.`Image` AS `Profile_Image`, `Posts`.`Image` AS `Post_Image`, `Posts`.`Message`, `Posts`.`Creation_Date`
                FROM `Posts` JOIN `Users`
                WHERE `Posts`.`User_ID` = `Users`.`User_ID` AND `Users`.`Login` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($_SESSION['Logged_user']));

        $data = $sth->fetchAll();
        return $data;
    }

    public function get_user_data($user)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Users`.`Login`, `Users`.`Image` AS `Profile_Image`, `Posts`.`Image` AS `Post_Image`, `Posts`.`Message`, `Posts`.`Creation_Date`
                FROM `Posts` JOIN `Users`
                WHERE `Posts`.`User_ID` = `Users`.`User_ID` AND `Users`.`Login` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($user));

        $data = $sth->fetchAll();
        return $data;
    }

    public function check_user($login)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Login` FROM `Users` WHERE `Login` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($login));

        $data = $sth->fetchAll();

        if (!empty($data))
            return (true);
        return (false);
    }

    public function get_image_name($id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Image` FROM `Users` WHERE `User_ID` = ?';
        $sth = $pdo->prepare($sql);
        $sth = $pdo->execute(array($id));

        $data = $sth->fetchAll();
        return ($data);
    }

    public function get_profile_image($image_name)
    {
        require 'config/ftp.php';

        $image = file_get_contents($FTP_CONN . 'user_profile_images/' . $image_name);
        return $image;
    }

    public function get_post_image($image_name)
    {
        require 'config/ftp.php';

        $image = file_get_contents($FTP_CONN . 'user_images/' . $image_name);
        return $image;
    }
}