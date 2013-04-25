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
            if($_POST)
            {
                $settings = Jelly::query('setting')->select_all();

                foreach ($settings as $s)
                {
                    $s->set(array('status' => ($_POST[$s->title] ? 1 : 0)))->save();
                }
            }

			$settings = Jelly::query('setting')->select_all();

            $this->view()->settings = $settings;
		}
		else
		{
			$this->redirect('/');
		}
	}
} // End Welcome
