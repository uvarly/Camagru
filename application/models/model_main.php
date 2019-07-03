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

        $sql = 'SELECT `Login` FROM `Users` WHERE `Login` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($param));

        $login = $sth->fetchAll();
        return $login;
    }

    public function get_email($param)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Email` FROM `Users` WHERE `Email` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($param));

        $email = $sth->fetchAll();
        return $email;
    }

    public function get_message($param)
	{
		require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Message` FROM `Posts` WHERE `Message` = ?';
        $sth = $pdo->prapare($sql);
        $sth->execute(array($param));

        $message = $sth->fetchAll();
        return $message;
	}

	public function get_datetime($param)
	{
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Creation_Date` FROM `Posts` WHERE `Creation_Date` = ?';
        $sth = $pdo->prapare($sql);
        $sth->execute(array($param));

        $datetime = $pdo->fetchAll();
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