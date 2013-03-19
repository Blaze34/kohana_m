<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Web {

    public function before()
    {
        $this->layout = 'admin';
        return parent::before();
    }

	public function action_index()
	{
		$this->view();
	}
} // End Welcome
