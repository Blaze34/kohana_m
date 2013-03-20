<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Web {

    public function before()
    {
        if (in_array($this->request->action(), array('index')))
        {
            $this->layout = 'admin';
        }
        return parent::before();
    }

	public function action_index()
	{
		if($this->allowed())
		{
			$this->view();
		}
		else
		{
			$this->redirect();
		}
	}
} // End Welcome
