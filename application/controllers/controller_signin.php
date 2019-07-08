<?php

class Controller_Signin extends Controller {
    public function __construct() {
		$this->model = new Model_Signin();
		$this->view	 = new View();
    }

    public function action_index() {
        $this->view->generate('signin_view.php', 'template_view.php', null);
    }

    public function action_authorize() {
        $result = $this->model->signin_user();
        switch ($result) {
            case 'success':
                $this->view->generate('signin_view.php', 'template_view.php', 'success');
                break;
            case 'fail':
                $this->view->generate('signin_view.php', 'template_view.php', 'fail');
                if (rand() % 2 == 0)
                    header('Location: https://youtu.be/OCsMKypvmB0');
                else
                    header('Location: https://youtu.be/SplJ7U0Jgtw');
                break;
            case 'bad_login':
                $this->view->generate('signin_view.php', 'template_view.php', 'bad_login');
                break;
            case 'bad_passw':
                $this->view->generate('signin_view.php', 'template_view.php', 'bad_passw');
                break;
        }
    }
}
