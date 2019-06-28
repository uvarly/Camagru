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
		$data = $this->model->get_data();
		$this->view->generate('profile_view.php', 'template_view.php', $data);
	}

	public function action_user($user)
	{
		if ($this->model->checkUser($user[0]) == true)
		{
			$data = $this->model->get_data();
			$this->view->generate('profile_view.php', 'template_view.php', $data);
		}
		else
		{
			// header('HTTP/1.1 404 Not Found');
        	// header('Status: 404 Not Found');
        	// header('Location: http://' . $_SERVER['HTTP_HOST'] . '/404');
		}
	}

	public function action_profile_image($image_name)
	{
		$image = $this->model->get_profile_image($image_name[0]);
		header('Content-type: image/jpeg');
		echo $image;
	}

	public function action_post_image($image_name)
	{
		$image = $this->model->get_post_image($image_name[0]);
		header('Content-Type: image/jpg');
		echo $image;
	}
}