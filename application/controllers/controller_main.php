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
		$data = $this->model->get_data(null);
		$this->view->generate('main_view.php', 'template_view.php', $data);
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