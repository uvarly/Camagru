<?php

class Controller_Camera extends Controller {

    public function __construct() {
        $this->model = new Model_Camera();
        $this->view	 = new View();
    }

    public function action_index() {
        if (!$this->model->authenticate_user())
            header('Location: /');

        $this->view->generate('camera_view.php', 'template_view.php', null);
    }

    public function action_upload() {
        $result = $this->model->upload_image();

        switch ($result) {
            case 'success':
                header("Location: /profile");
                break;
            case 'no_image':
                header("Location: /camera");
                break;
        }
    }

    public function action_upload_base() {
        $result = $this->model->upload_image_base();

        switch ($result) {
            case 'success':
                header("Location: /profile");
                break;
            case 'no_image':
                header("Location: /camera");
                break;
        }
    }
}