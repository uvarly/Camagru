<?php

class Controller_Signup extends Controller {
    public function __construct() {
		$this->model = new Model_Signup();
		$this->view	 = new View();
    }

    public function action_index() {
        $this->view->generate('signup_view.php', 'template_view.php', null);
    }

    public function action_insert() {
        $result = $this->model->insert_user();

        switch ($result) {
            case 'success':
                $this->view->generate('signup_view.php', 'template_view.php', 'success');
                break;
            case 'bad_login':
                $this->view->generate('signup_view.php', 'template_view.php', 'bad_login');
                break;
            case 'bad_passw':
                $this->view->generate('signup_view.php', 'template_view.php', 'bad_passw');
                break;
            case 'bad_email':
                $this->view->generate('signup_view.php', 'template_view.php', 'bad_email');
                break;
            case 'bad_submit':
                $this->view->generate('signup_view.php', 'template_view.php', 'bad_submit');
                break;
            case 'user_exists':
                $this->view->generate('signup_view.php', 'template_view.php', 'user_exists');
                break;
            case 'email_exists':
                $this->view->generate('signup_view.php', 'template_view.php', 'email_exists');
                break;
            case 'malicious_file':
                $this->view->generate('signup_view.php', 'template_view.php', 'malicious_file');
                break;
        }
    }
}
