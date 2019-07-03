<?php

class Controller_Main extends Controller
{
	public function __construct()
	{
		$this->model = new Model_Main();
		$this->view	 = new View();
	}

	public function action_index()
	{	
		$data = $this->model->get_data();
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}

	public function action_sign_out()
	{
		session_destroy();
		header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
	}

	public function action_get_login($param)
	{
		$login = $this->model->get_login($param[0]);
		header('Content-type: text/plain');
		echo $login;
	}

	public function action_get_email($param)
	{
		$email = $this->model->get_email($param[0]);
		header('Content-type: text/plain');
		echo $email;
	}

	public function action_get_message($param)
	{
		$message = $this->model->get_message($param[0]);
		header('Content-type: text/plain');
		echo $message;
	}

	public function action_get_datetime($param)
	{
		$datetime = $this->model->get_datetime($param[0]);
		header('Content-type: text/plain');
		echo $datetime;
	}

	public function action_get_profile_image($param)
	{
		$image = $this->model->get_profile_image($param[0]);
		header('Content-type: image/jpg');
		echo $image;
	}

	public function action_get_post_image($param)
	{
		$image = $this->model->get_post_image($param[0]);
		header('Content-Type: image/jpg');
		echo $image;
	}

	/**
	 * Подлежит удалению!
	 */
	public function action_import()
	{
		require_once 'config/content.php';
	}
}