<?php

class Controller_Recover extends Controller {
    public function __construct() {
		$this->model = new Model_Recover();
		$this->view	 = new View();
    }

    public function action_index() {
        $this->view->generate('recover_view.php', 'template_view.php', null);
    }

    public function action_check() {
        $result = $this->model->check_email();

        switch ($result) {
            case 'success':
                $this->view->generate('recover_view.php', 'template_view.php', 'email_success');
                break;
            case 'fail':
                $this->view->generate('recover_view.php', 'template_view.php', 'email_fail');
                break;
        }
    }
}