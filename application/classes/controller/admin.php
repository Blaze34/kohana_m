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
                    $s->set(array('status' => (Arr::get($_POST[$s->title], 'status') ? 1 : 0)))->save();
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

    public function action_edit()
    {
        if($this->allowed())
        {
            if($id = $this->request->param('id'))
            {
                $setting = Jelly::factory('setting', $id);

                if($setting->loaded())
                {
                    if($_POST)
                    {
						$setting->set(array('value' => Arr::get($_POST, $setting->title)))->save();

						if($setting->saved())
						{
							$this->errors('Сохранено')->redirect();
						}
                    }

                    $this->view()->setting = $setting;
                }
                else
                {
                    $this->redirect();
                }

            }
        }
        else
        {
            $this->redirect('/');
        }

    }
} // End Welcome
