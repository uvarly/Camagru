<?php

class Model
{
    public function get_data()
    {
    }

    public function action_signout()
	{
		session_start();
		$_SESSION = array();
		session_destroy();
		header('Location: /');
	}
}
