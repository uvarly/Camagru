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
                FROM    `Posts`
                JOIN `Users` ON `Posts`.`User_ID` = `Users`.`User_ID`
                ORDER BY `Posts`.`Creation_Date` DESC';

        $sth = $pdo->prepare($sql);
        $sth->execute();
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

    public function get_data_post($post_id) {
        require 'config/database.php';

        if (!$this->_check_post_id($post_id))
            return 'no_post';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT  `Users`.`User_ID`,
                        `Users`.`Login`,
                        `Users`.`Image` AS `Profile_Image`,
                        `Posts`.`Post_ID`,
                        `Posts`.`Image` AS `Post_Image`,
                        `Posts`.`Message`,
                        `Posts`.`Creation_Date`
                FROM    `Posts`
                JOIN `Users` ON `Posts`.`User_ID` = `Users`.`User_ID` AND `Posts`.`Post_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id));

        $data['post'] = $sth->fetch();

        $sql = 'SELECT COUNT(`Likes`.`Post_ID`) AS `Likes`, `Likes`.`Post_ID`
                FROM `Posts` JOIN `Likes`
                WHERE `Posts`.`Post_ID` = `Likes`.`Post_ID` AND `Posts`.`Post_ID` = ?
                GROUP BY `Likes`.`Post_ID`
                ORDER BY `Posts`.`Post_ID` ASC';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id));

        $data['likes'] = $sth->fetch();

        $sql = 'SELECT  `Users`.`Login`,
                        `Comments`.`Message`,
                        `Comments`.`Creation_Date`,
                        `Comments`.`User_ID`,
                        `Comments`.`Comment_ID`
                FROM `Users` JOIN `Comments`
                WHERE `Comments`.`Post_ID` = ? AND `Comments`.`User_ID` = `Users`.`User_ID`
                ORDER BY `Comments`.`Creation_Date` ASC';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id));

        $data['comments'] = $sth->fetchAll();

        return $data;
    }

    public function delete_post($post_id, $user_id)
    {
        require 'config/database.php';

        if (!$this->_check_post_id($post_id))
            return ;

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Post_ID`, `User_ID` FROM `Posts` WHERE `Post_ID` = ? AND `User_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id, $user_id));

        $result = $sth->fetch();
        if ($result == false)
            return;

        $sql = 'DELETE FROM `Posts` WHERE `Post_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id));

        $sql = 'DELETE FROM `Comments` WHERE `Post_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($post_id));
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

        $this->_send_mail($post_id, $user_id);
    }

    public function delete_comment($comment_id, $user_id)
    {
        require 'config/database.php';

        if (!$this->_check_comment_id($comment_id))
            return ;

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Comment_ID`, `User_ID` FROM `Comments` WHERE `Comment_ID` = ? AND `User_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($comment_id, $user_id));

        $result = $sth->fetch();
        if ($result == false)
            return ;

        $sql = 'DELETE FROM `Comments` WHERE `Comments`.`Comment_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($comment_id));
    }

    public function add_or_remove_like($post_id, $user_id)
    {
        if (!isset($_POST['like']) || $_POST['like'] != 'like')
            return;

        if (!$this->_check_post_id($post_id) || !$this->_check_user_id($user_id))
            return;

        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        if ($this->_like_exists($post_id, $user_id))
            $sql = 'DELETE FROM `Likes` WHERE `User_ID` = ? AND `Post_ID` = ?';
        else
            $sql = 'INSERT INTO `Likes` (`User_ID`, `Post_ID`) VALUES (?, ?)';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user_id, $post_id));
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

    private function _check_comment_id($comment_id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Comment_ID` FROM `Comments` WHERE `Comment_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($comment_id));

        $result = $sth->fetchAll();

        foreach ($result as $match)
        {
            if ($comment_id == $match['Comment_ID'])
                return true;
        }
        return false;
    }

    private function _check_user_id($user_id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `User_ID`, `Login`, `Email` FROM `Users` WHERE `User_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user_id));

        $result = $sth->fetchAll();

        if (!isset($_SESSION['Logged_user']) || empty($_SESSION['Logged_user']) ||
                !isset($_SESSION['Logged_user_ID']) || empty($_SESSION['Logged_user_ID']) ||
                !isset($_SESSION['Session_ID']) || empty($_SESSION['Session_ID']))
            return false;

        foreach ($result as $match)
        {
            if ($user_id == $match['User_ID'] &&
                    $_SESSION['Logged_user'] == $match['Login'] &&
                    $_SESSION['Session_ID'] == hash('whirlpool', $match['User_ID'] . $match['Login']))                
                return true;
        }
        return false;
    }

    private function _like_exists($post_id, $user_id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `User_ID`, `Post_ID` FROM `Likes` WHERE `User_ID` = ? AND `Post_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user_id, $post_id));

        $result = $sth->fetchAll();

        foreach ($result as $match)
        {
            if ($user_id == $match['User_ID'] &&
                    $post_id == $match['Post_ID'])
                return true;
        }
        return false;
    }

    private function _send_mail($post_id, $user_id)
    {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
        $sql = 'SELECT `Email`, `Send_Mail` FROM `Users` WHERE `User_ID` = ?';

        $sth = $pdo->prepare($sql);
        $sth->execute(array($user_id));

        $result = $sth->fetch();
        $email = $result['Email'];
        $allowed = $result['Send_Mail'];

        if ($allowed == 0)
            return ;

        $to      = $email;
        $subject = 'Camagru: New Comment';
        $message = 'Someone left a comment under your post. Link: ' . $_SERVER['HTTP_HOST'] . '/';
        $message = wordwrap($message, 70, '\r\n');
        $headers =  'From: somerussianlad@gmail.com' . "\r\n" .
                    'Reply-To: somerussianlad@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}