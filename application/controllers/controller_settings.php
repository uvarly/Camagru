<?php

class Controller_Settings extends Controller
{
	public function __construct() {
		$this->model = new Model_Main();
		$this->view	 = new View();
	}

	public function action_index() {
		$this->_authorize();		
		$this->view->generate('settings_view.php', 'template_view.php', null);
	}

	public function action_image() {
		$this->_authorize();		
		$result = $this->model->change_image();
		$this->view->generate('settings_view.php', 'template_view.php', $result);
	}

	public function action_notifications() {
		$this->_authorize();		
		$this->model->change_notifications();
		$this->view->generate('settings_view.php', 'template_view.php', 'notifications_changed');
	}

	public function action_login() {
		$this->_authorize();
		$result = $this->model->change_login();
		$this->view->generate('settings_view.php', 'template_view.php', $result);
	}

	public function action_email() {
		$this->_authorize();
		$result = $this->model->change_email();
		$this->view->generate('settings_view.php', 'template_view.php', $result);
	}

	public function action_passw() {
		$this->_authorize();
		$result = $this->model->change_password();
		$this->view->generate('settings_view.php', 'template_view.php', $result);
	}

	private function _authorize() {
		if (!isset($_SESSION['Logged_user']) || empty($_SESSION['Logged_user']) ||
				!isset($_SESSION['Session_ID']) || empty($_SESSION['Session_ID']) ||
				!isset($_SESSION['Logged_user']) || empty($_SESSION['Logged_user']) ||
				!isset($_SESSION['Logged_user_ID']) || empty($_SESSION['Logged_user_ID']) ||
				$_SESSION['Session_ID'] != hash('whirlpool', $_SESSION['Logged_user_ID'] . $_SESSION['Logged_user']) ||
				!isset($_SESSION['Confirmed']) || empty($_SESSION['Confirmed']) || $_SESSION['Confirmed'] != "1")
			header('Location: /');
	}
}