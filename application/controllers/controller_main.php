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
		$data['posts'] = $this->model->get_posts();
		$data['comments'] = $this->model->get_comments();
		$this->view->generate('main_view.php', 'template_view.php', $data);
	}

	public function action_signout()
	{
		session_start();
		$_SESSION = array();
		session_destroy();
		header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
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