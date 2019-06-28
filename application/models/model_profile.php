<?php

class Model_Profile extends Model
{
    public function get_data()
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $data = $pdo->query('
            SELECT `Users`.`Login`, `Users`.`Image` AS `Profile_Image`, `Posts`.`Image` AS `Post_Image`, `Posts`.`Message`, `Posts`.`Creation_Date` 
            FROM `Posts` JOIN `Users`
            WHERE `Posts`.`User_ID` = `Users`.`User_ID` AND `Users`.`User_ID` = \'' . $_SESSION['Logged_user'] . '\'
        ');

        return $data;
    }

    public function checkUser($user)
    {
        require 'config/database.php';

        if (empty($user[0]))
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/profile');
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $data = $pdo->exec('
            SELECT `Login`
            FROM `Users`
            WHERE `Login` = ' . $user . '
        ');
        if ($data)
            return (true);
        return (false);
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