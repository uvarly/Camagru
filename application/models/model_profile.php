<?php

class Model_Profile extends Model
{
    public function get_data()
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT  `Users`.`User_ID`,
                        `Users`.`Login`,
                        `Users`.`Image` AS `Profile_Image`,
                        `Posts`.`Post_ID`,
                        `Posts`.`Image` AS `Post_Image`,
                        `Posts`.`Message`,
                        `Posts`.`Creation_Date`
                FROM    `Posts`
                JOIN `Users` ON `Posts`.`User_ID` = `Users`.`User_ID`
                ORDER BY `Posts`.`Creation_Date` DESC';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($_SESSION['Logged_user']));

        $data['posts'] = $sth->fetchAll();

        $sql = 'SELECT COUNT(`Likes`.`Post_ID`) AS `Likes`, `Likes`.`Post_ID`
                FROM `Posts` JOIN `Likes`
                WHERE `Posts`.`Post_ID` = `Likes`.`Post_ID`
                GROUP BY `Likes`.`Post_ID`
                ORDER BY `Posts`.`Post_ID` ASC';

        $sth = $pdo->prepare($sql);
        $sth->execute();
        $data['likes'] = $sth->fetchAll();

        return $data;
    }

    public function get_user_data($user)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT  `Users`.`User_ID`,
                        `Users`.`Login`,
                        `Users`.`Image` AS `Profile_Image`,
                        `Posts`.`Post_ID`,
                        `Posts`.`Image` AS `Post_Image`,
                        `Posts`.`Message`,
                        `Posts`.`Creation_Date`
                FROM    `Posts`
                JOIN `Users` ON `Posts`.`User_ID` = `Users`.`User_ID`
                ORDER BY `Posts`.`Creation_Date` DESC';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user));

        $data['posts'] = $sth->fetchAll();

        $sql = 'SELECT COUNT(`Likes`.`Post_ID`) AS `Likes`, `Likes`.`Post_ID`
                FROM `Posts` JOIN `Likes`
                WHERE `Posts`.`Post_ID` = `Likes`.`Post_ID`
                GROUP BY `Likes`.`Post_ID`
                ORDER BY `Posts`.`Post_ID` ASC';

        $sth = $pdo->prepare($sql);
        $sth->execute();
        $data['likes'] = $sth->fetchAll();

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