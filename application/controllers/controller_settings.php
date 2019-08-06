<?php

class Controller_Settings extends Controller
{
	public function __construct() {
		$this->model = new Model_Main();
		$this->view	 = new View();
	}

	public function action_index() {
	}
}