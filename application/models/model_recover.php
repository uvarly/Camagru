<?php

class Model_Recover extends Model {
    public function check_email() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'SELECT `Email` FROM `Users` WHERE `Email` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($_POST['email']));

        $data = $sth->fetch();

        if ($data == false)
            return 'fail';
        
        $this->_add_temporary_password();
        $this->_send_password_via_mail();
        
        return 'success';
    }

    private function _add_temporary_password() {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $new_passw = hash('crc32', $_POST['email']);
        $new_passw = hash('whirlpool', $new_passw);

        $sql = 'UPDATE `Users` SET `Password` = ? WHERE `Email` = ?';
        $sth = $pdo->prepare($sql);
        $sth->execute(array($new_passw, $_POST['email']));
    }

    private function _send_password_via_mail() {
        $to      = $_POST['email'];
        $subject = 'Camagru: Password recovery';
        $message = 'Here\'s your new temporary password: ' . hash('crc32', $_POST['email']) . '. We suggest you change it to a new one as soon as possible.';
        $message = wordwrap($message, 70, "\r\n");
        $headers =  'From: somerussianlad@gmail.com' . "\r\n" .
                    'Reply-To: somerussianlad@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}