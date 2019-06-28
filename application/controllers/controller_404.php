<?php

class Controller_404 extends Controller
{
	function action_index()
	{
		$this->view->generate('404_view.php', 'template_view.php');
		// switch (rand() % 2)
		// {
		// 	case (0):
		// 		header("Location: https://youtu.be/FaJJP_7jbxs");
		// 		break;
		// 	case (1):
		// 		header("Location: https://youtu.be/SplJ7U0Jgtw?t=1");
		// 		break;
		// }
	}
}
