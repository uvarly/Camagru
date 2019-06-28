<?php

class View
{
    public function generate($content_view, $template_view, $data = null)
    {
        require 'application/views/' . $template_view;
    }
}
