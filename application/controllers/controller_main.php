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

	public function action_signout()
	{
		session_start();
		$_SESSION = array();
		session_destroy();
		header('Location: /');
	}

	public function action_post($params)
	{
		$post_id = $params[0];

		$data = $this->model->get_data_post($post_id);
		switch ($data) {
			case 'no_post':
				header('HTTP/1.1 404 Not Found');
				header('Status: 404 Not Found');
				header('Location: /404');
				break;
			default:
				$this->view->generate('post_view.php', 'template_view.php', $data);
				break;		
		}
	}

	public function action_delete_post($params)
	{
		if (!isset($_SESSION['Logged_user_ID']) || empty($_SESSION['Logged_user_ID']) ||
				!isset($params[0]) || empty($params[0]))
			header('Location: /');

		$post_id = $params[0];
		$user_id = $_SESSION['Logged_user_ID'];

		$this->model->delete_post($post_id, $user_id);
		header('Location: /');
	}

	public function action_comment($params)
	{
		$post_id = $params[0];
		$user_id = $_SESSION['Logged_user_ID'];

		$this->model->add_comment($post_id, $user_id);
		header('Location: /');
	}

	public function action_delete_comment($params)
	{
		$comment_id = $params[0];
		$user_id = $_SESSION['Logged_user_ID'];

		echo $this->model->delete_comment($comment_id, $user_id);
		// header('Location: /');
	}

	public function action_like($params)
	{
		$post_id = $params[0];
		$user_id = $_SESSION['Logged_user_ID'];

		$this->model->add_or_remove_like($post_id, $user_id);
		header('Location: /');
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