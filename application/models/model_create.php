<?php

class Model_Create extends Model
{
    public function authenticate_user()
    {
        if (!isset($_SESSION['Logged_user']))
            return false;
        return true;
    }

    public function check_form()
    {
        if (isset($_POST['Message']) && !empty($_POST['Message']) &&
                    isset($_POST['Submit']) && $_POST['Submit'] == 'Submit' &&
                    $_FILES['Post_Image']['error'] != 4)
                echo "RERORERORERORERO";
            var_dump($_POST);
            var_dump($_FILES);
    }

    public function check_file()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $ext = finfo_file($finfo, $_FILES['Post_Image']['tmp_name']);

        $tmp = explode('/', $ext);
        $ext = end($tmp);

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowed_ext))
            return false;
        return true;
    }

    public function upload_file()
    {
        if (!isset($_FILES['Post-Image']))
            return false;
        
        
    }
}