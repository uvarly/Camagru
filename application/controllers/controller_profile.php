<?php

class Controller_Profile extends Controller
{
	public function __construct()
	{
		$this->model = new Model_Profile();
		$this->view	 = new View();
	}

	public function action_index()
	{
		if (!isset($_SESSION['Logged_user']) || empty($_SESSION['Logged_user']) || $_SESSION['Session_ID'] != hash('whirlpool', $_SESSION['Logged_user_ID'] . $_SESSION['Logged_user']))
			header('Location: /');

		$data = $this->model->get_data();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}

	public function action_user($user)
	{
		$login = $user[0];

		if (!isset($login) || empty($login))
			header('Location: /');

		if ($this->model->check_user($login) == true)
		{
			$data = $this->model->get_user_data($login);
			$this->view->generate('profile_view.php', 'template_view.php', $data);
		}
		else
		{
			header('HTTP/1.1 404 Not Found');
        	header('Status: 404 Not Found');
        	header('Location: /404');
		}
	}

	public function action_get_profile_image($image_name)
	{
		// if (preg_match('/^[0-9]+$/gm', $image_name) == 1)
		// {
		// 	$kek = preg_match('/^[0-9]+$/gm', $image_name);
		// 	var_dump($kek);
		// 	$image_name = get_image_name($image_name);
		// 	$image = $this->model->get_profile_image($image_name);
		// 	header('Content-type: image/jpeg');
		// 	echo $image;
		// }
		// else
		// {
			$image = $this->model->get_profile_image($image_name[0]);
			header('Content-type: image/jpeg');
			echo $image;
		// }
	}

	public function action_get_post_image($image_name)
	{
		$image = $this->model->get_post_image($image_name[0]);
		header('Content-Type: image/jpg');
		echo $image;
	}
}