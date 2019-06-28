<?php

class Controller_Signup extends Controller
{
    public function __construct()
	{
		$this->model = new Model_Signup();
		$this->view	 = new View();
    }

    public function action_index()
    {
        $this->view->generate('signup_view.php', 'template_view.php', 0);
    }

    public function action_insert()
	{
        $login = $_POST['login'];
        $passw = $_POST['passw'];
        $email = $_POST['email'];
        $image = $_POST['image'];

        $this->model->insert_user($login, $passw, $email, $image);

        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
    }
}
