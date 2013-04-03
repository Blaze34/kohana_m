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

            $categories = $this->get_category_options();

            if ($_POST)
            {
                try
                {
                    $holder->set(array(
                        'title' => Arr::get($_POST, 'title'),
                        'body' => html_entity_decode(Arr::get($_POST, 'body', ''), ENT_QUOTES),
                        'activity' => Arr::get($_POST, 'activity'),
                        'category' => Arr::get($_POST, 'category')
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

            $this->view(array('holder' => $holder, 'categories' => $categories));
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
            $categories = $this->get_category_options();

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
                            'category' => Arr::get($_POST, 'category')
                        ))->save();
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }

                    if ($holder->saved())
                    {
//                        $this->redirect(Route::url('default', array('controller' => 'holder')));
                    }
                }

                $this->view(array('holder' => $holder, 'categories' => $categories));
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

    protected function get_category_options()
    {
        $categories = Jelly::query('category')->order_by('parent_id')->order_by('sort')->select_all();
        $options = $sections = array();

        foreach ($categories as $c)
        {
            if ($c->parent_id)
            {
                if ($optgroup = Arr::get($sections, $c->parent_id))
                {
                    $options[$optgroup][$c->id()] = $c->name;
                }
            }
            else
            {
                $sections[$c->id()] = $c->name;
                $options[$c->name] = array();
            }
        }

        return $options;
    }

} // End Welcome