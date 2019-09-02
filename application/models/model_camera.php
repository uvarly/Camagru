<?php

class Model_Camera extends Model
{
    public function authenticate_user()
    {
        if (!isset($_SESSION['Logged_user']))
            return false;
        return true;
    }

    public function upload_image() {
        if (!is_uploaded_file($_FILES['image']['tmp_name']))
            return 'no_image';

        $image_name = hash('crc32', rand()) . '.jpg';

        $this->_update_db($image_name);
        $this->_update_ftp($image_name);

        return 'success';
    }

    public function upload_image_base() {
        if (!isset($_POST['base_img']))
            return 'no_image';

        $data = explode(',' , $_POST['base_img']);
        $img = imagecreatefromstring(base64_decode($data[1]));
        if ($img === false)
            return 'no_image';

        $image_name = hash('crc32', rand()) . '.jpg';
        
        $this->_update_db($image_name);
        $this->_update_ftp_base($img, $image_name);
        
        return 'success';
    }

    private function _update_db($image_name) {
        require 'config/database.php';

        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);

        $sql = 'INSERT INTO `Posts` (`User_ID`, `Image`, `Message`, `Creation_Date`) VALUES (?, ?, ?, NOW())';
    
        $id = $_SESSION['Logged_user_ID'];
        $message = isset($_POST['description']) ? mb_strimwidth($_POST['description'], 0, 250) : null;

        $sth = $pdo->prepare($sql);
        $sth->execute(array($id, $image_name, $message));
    }

    private function _update_ftp($image_name) {
        require 'config/ftp.php';

        $type = exif_imagetype($_FILES['image']['tmp_name']);
		switch ($type) {
			case IMAGETYPE_JPEG:
				$src_img = imagecreatefromjpeg($_FILES['image']['tmp_name']);
				break;
			case IMAGETYPE_GIF:
				$src_img = imagecreatefromgif($_FILES['image']['tmp_name']);
				break;
			case IMAGETYPE_PNG:
				$src_img = imagecreatefrompng($_FILES['image']['tmp_name']);
				break;
        }

        $image = imagescale($src_img, 640, 480);
        if (isset($_POST['sticker0']))
            $image = $this->_add_stickers($image);
        imagejpeg($image, $FTP_CONN . "user_images/$image_name");
    }

    private function _update_ftp_base($img, $image_name) {
        require 'config/ftp.php';

        $img = imagescale($img, 640, 480);

		if (isset($_POST['sticker0']))
            $img = $this->_add_stickers($img);

        imagejpeg($img, $FTP_CONN . "user_images/$image_name");
    }

    private function _add_stickers($img) {
		for ($i = 0; ; $i++) {
			if (!isset($_POST['sticker' . $i]))
				break ;
			$param = explode(';', $_POST['sticker' . $i]);
			$sticker = imagecreatefrompng('images/stickers/' . $param[0]);
			imagecopy($img, $sticker, $param[1] - 64, $param[2] - 64, 0, 0, 128, 128);
		}
		return $img;
	}
}