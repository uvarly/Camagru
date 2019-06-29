<?php

class Model_Create extends Model
{
    public function get_data()
    {
    }

    public function authenticate_user()
    {
        if (!isset($_SESSION['Logged_user']))
            return false;
        return true;
    }

    public function check_file()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $ext = finfo_file($finfo, $_FILES['Post_Image']['tmp_name']);

        $tmp = explode('/', $ext);
        $ext = end($tmp);

        $allowed_ext = array('jpeg', 'jpg', 'png', 'gif');
        if (!in_array($ext, $allowed_ext))
            return false;
    }
}