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

    public function add_comment($post_id, $user_id)
    {
        if (!isset($_POST['comment']) || empty($_POST['comment']))
            return;
        
        if (!isset($_POST['submit']) || $_POST['submit'] != 'OK')
            return;
        
        if (!$this->_check_post_id($post_id) || !$this->_check_user_id($user_id))
            return;

        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'INSERT INTO `Comments` (`User_ID`, `Post_ID`, `Message`) VALUES (?, ?, ?)';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user_id, $post_id, $_POST['comment']));
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

    private function _check_post_id($post_id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Post_ID` FROM `Posts` WHERE `Post_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id));

        $result = $sth->fetchAll();

        foreach ($result as $match)
        {
            if ($post_id == $match['Post_ID'])
                return true;
        }
        return false;
    }

    private function _check_user_id($user_id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `User_ID` FROM `Users` WHERE `User_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user_id));

        $result = $sth->fetchAll();

        foreach ($result as $match)
        {
            if ($user_id == $match['User_ID'])
                return true;
        }
        return false;
    }
}