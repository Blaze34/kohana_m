<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Web {

	public function action_index()
	{

	}

    public function action_last()
    {
        $show_count = Kohana::$config->load('comment.last');

        $comments = array_fill(0, $show_count, 'comment');

        $this->view()->comments = $comments;
    }
} // End Welcome
