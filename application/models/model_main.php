<?php

class Model_Main extends Model
{
    public function get_data()
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $data = $pdo->query('
            SELECT `Users`.`Login`, `Users`.`Image` AS `Profile_Image`, `Posts`.`Image` AS `Post_Image`, `Posts`.`Message`, `Posts`.`Creation_Date` 
            FROM `Posts` JOIN `Users`
            WHERE `Posts`.`User_ID` = `Users`.`User_ID`
        ');
        return $data;
    }

    public function get_login($param)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $login = $pdo->query("SELECT `Login` FROM `Users` WHERE `Login` = '$param'");

        return $login;
    }

    public function get_email($param)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $email = $pdo->exec("SELECT `Email` FROM `Users` WHERE `Email` = '$param'");

        return $email;
    }

    public function get_message($param)
	{
		require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $message = $pdo->exec("SELECT `Message` FROM `Posts` WHERE `Message` = '$param'");

        return $message;
	}

	public function get_datetime($param)
	{
		require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $datetime = $pdo->exec("SELECT `Creation_Date` FROM `Posts` WHERE `Creation_Date` = '$param'");

        return $datetime;
    }
    
    public function get_profile_image($param)
    {
        require 'config/ftp.php';

        $image = file_get_contents($FTP_CONN . 'user_profile_images/' . $param);
        return $image;
    }

    public function get_post_image($param)
    {
        require 'config/ftp.php';

        $image = file_get_contents($FTP_CONN . 'user_images/' . $param);
        return $image;
    }
}