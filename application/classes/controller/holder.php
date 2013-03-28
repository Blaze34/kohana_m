<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Holder extends Controller_Web {

    public function before()
    {
        if (in_array($this->request->action(), array('index', 'edit', 'add')))
        {
            $this->layout = 'admin';
        }
        return parent::before();
    }

    public function action_add()
    {
        if ($this->allowed())
        {
            $this->js('jquery.tinymce.js');
            $holder = Jelly::factory('holder');

            if ($_POST)
            {
                try
                {
                    $holder->set(array(
                        'title' => Arr::get($_POST, 'title'),
                        'body' => html_entity_decode(Arr::get($_POST, 'body', ''), ENT_QUOTES),
                        'activity' => Arr::get($_POST, 'activity')
                    ))->save();
                }
                catch (Jelly_Validation_Exception $e)
                {
                    $this->errors($e->errors('errors'));
                }

                if ($holder->saved())
                {
                    $this->redirect(Route::url('default', array('controller' => 'holder')));
                }
            }

            $this->view()->holder = $holder;
        }
        else
        {
            $this->error('global.no_permisson')->redirect('/');
        }
    }

    public function action_index()
    {
        if ($this->allowed())
        {
            $holders = Jelly::query('holder')->select_all();
            
            $this->view()->holders = $holders;
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_edit()
    {
        if ($this->allowed())
        {
            $this->js('jquery.tinymce.js');
            $holder = Jelly::factory('holder', $this->request->param('id'));

            if ($holder->loaded())
            {
                if ($_POST)
                {
                    try
                    {
                        $holder->set(array(
                            'title' => Arr::get($_POST, 'title'),
                            'body' => html_entity_decode(Arr::get($_POST, 'body', ''), ENT_QUOTES),
                            'activity' => Arr::get($_POST, 'activity'),
                        ))->save();
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }

                    if ($holder->saved())
                    {
                        $this->redirect(Route::url('default', array('controller' => 'holder')));
                    }
                }

                $this->view()->holder = $holder;
            }
            else
            {
                $this->redirect(Route::url('default', array('controller' => 'menu')));
            }
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_delete()
    {
        if ($this->allowed())
        {
            $holder = Jelly::factory('holder', $this->request->param('id'));

            if($holder->loaded())
            {
                $holder->delete();
            }
            else
            {
                $this->errors('global.no_exist');
            }

            $this->redirect(Route::url('default', array('controller' => 'holder')));
            
        }
        else
        {
            $this->redirect('/');
        }
    }

} // End Welcome