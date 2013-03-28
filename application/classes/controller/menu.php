<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Menu extends Controller_Web {

    public function before()
    {
        if ($this->request->action())
        {
            $this->layout = 'admin';
        }
        return parent::before();
    }

    public function action_index()
    {
        if ($this->allowed())
        {
            $menus = Jelly::query('menu')->order_by('id', 'DESC')->select_all()->as_array('id', 'name');
            $links = Jelly::query('menu_link')->order_by('sort')->select_all();

            $output = array();

            foreach ($links as $l)
            {
                $output[$l->menu->id()][$l->id()] = $l->as_array();
            }

            $this->view()->menus = $menus;
            $this->view()->links = $output;
        }
        else
        {
            $this->redirect();
        }
    }

    public function action_add_menu()
    {
        if ($this->allowed())
        {
            $menu = Jelly::factory('menu');

            if ($_POST)
            {
                try
                {
                    $menu->set(array(
                        'name' => Arr::get($_POST, 'name'),
                    ))->save();
                }
                catch (Jelly_Validation_Exception $e)
                {
                    $this->errors($e->errors('errors'));
                }

                if ($menu->saved())
                {
                    $this->redirect(Route::url('default', array('controller' => 'menu')));
                }
            }

            $this->view()->menu = $menu;
        }
        else
        {
            $this->error('global.no_permisson')->redirect('/');
        }
    }

    public function action_add_link()
    {
        if ($this->allowed())
        {
            $link = Jelly::factory('menu_link');

            if ($_POST)
            {
                try
                {
                    $link->set(array(
                        'name' => Arr::get($_POST, 'name'),
                        'sort' => Arr::get($_POST, 'sort'),
                        'url' => Arr::get($_POST, 'url'),
                        'menu' => $this->request->param('id'),
                    ))->save();
                }
                catch (Jelly_Validation_Exception $e)
                {
                    $this->errors($e->errors('errors'));
                }

                if ($link->saved())
                {
                    $this->redirect(Route::url('default', array('controller' => 'menu')));
                }
            }

            $this->view();

        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_edit_menu()
    {
        if ($this->allowed())
        {
            $menu = Jelly::factory('menu', $this->request->param('id'));

            if ($menu->loaded())
            {
                if ($_POST)
                {
                    try
                    {
                        $menu->set(array(
                            'name' => Arr::get($_POST, 'name'),
                        ))->save();
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }

                    if ($menu->saved())
                    {
                        $this->redirect(Route::url('default', array('controller' => 'menu')));
                    }
                }

                $this->view()->menu = $menu;
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

    public function action_edit_link()
    {
        if ($this->allowed())
        {
            $link = Jelly::factory('menu_link', $this->request->param('id'));
            if ($link->loaded())
            {
                if ($_POST)
                {
                    try
                    {
                        $link->set(array(
                            'name' => Arr::get($_POST, 'name'),
                            'sort' => Arr::get($_POST, 'sort'),
                            'url' => Arr::get($_POST, 'url'),
                        ))->save();
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }

                    if ($link->saved())
                    {
                        $this->redirect(Route::url('default', array('controller' => 'menu')));
                    }
                }

                $this->view()->link = $link;
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
            if($id = Arr::get($_GET, 'menu'))
            {
                $menu = Jelly::factory('menu', $id);

                if($menu->loaded())
                {
                    $menu->get('links')->delete();
                    $menu->delete();
                }
                else
                {
                    $this->errors('global.no_exist');
                }

                $this->redirect(Route::url('default', array('controller' => 'menu')));
            }
            elseif($id = Arr::get($_GET, 'link'))
            {
                $link = Jelly::factory('link', $id);

                if($link->loaded())
                {
                    $link->delete();
                }
                else
                {
                    $this->errors('global.no_exist');
                }

            }
            else
            {
                $this->errors('global.no_params');
            }
        }
        else
        {
            $this->redirect('/');
        }
    }

} // End Welcome