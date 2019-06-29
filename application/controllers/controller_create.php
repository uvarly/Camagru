<?php

class Controller_Create extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Create();
        $this->view	 = new View();
    }

    public function action_index()
    {
        if (!$this->model->authenticate_user())
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');

        $data = $this->model->get_data();
        $this->view->generate('create_view.php', 'template_view.php', $data);
    }

    public function action_new_post()
    {
        if (!$this->model->check_file())
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/create');

        if (!$this->model->upload_file())
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/create');
    }
}