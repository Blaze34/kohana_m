<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Menu extends Controller_Web {

    public function before()
    {
        if ($this->request->action() == 'index')
        {
            $this->layout = 'admin';
        }
        return parent::before();
    }

	public function action_show()
	{
        if($this->allowed() OR Request::current()->is_initial())
        {

            if ($id = $this->request->param('id'))
            {
                $menu = Jelly::factory('menu', 1);
                echo Debug::vars($menu->links->as_array());
            }
            else
            {
                $this->errors();
            }
        }
        else
        {
            $this->redirect('/');
        }
	}

} // End Welcome