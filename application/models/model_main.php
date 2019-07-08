<?php

class Model_Main extends Model
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
                FROM `Posts` JOIN `Users`
                WHERE `Posts`.`User_ID` = `Users`.`User_ID`
                ORDER BY `Posts`.`Creation_Date` DESC';

        $sth = $pdo->prepare($sql);
        $sth->execute();
        $data['posts'] = $sth->fetchAll();

        $sql = 'SELECT  `Users`.`Login`,
                        `Posts`.`Post_ID`,
                        `Comments`.`Message`,
                        `Comments`.`Creation_Date`
                FROM `Users` JOIN `Posts` JOIN `Comments`
                WHERE `Comments`.`Post_ID` = `Posts`.`Post_ID` AND `Comments`.`User_ID` = `Users`.`User_ID`
                ORDER BY `Comments`.`Creation_Date` ASC';

        $sth = $pdo->prepare($sql);
        $sth->execute();
        $data['comments'] = $sth->fetchAll();

        return $data;
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