<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Static extends Controller_Web {

    public function before()
    {
        if (in_array($this->request->action(), array('add', 'edit', 'index')))
        {
            $this->layout = 'admin';
        }

        return parent::before();

    }

    public function action_index()
    {
        if ($this->allowed())
        {
            $this->view()->statics = Jelly::query('static')->pagination()->execute();
        }
        else
        {
            $this->redirect();
        }
    }

    public function action_view()
    {
        $alias = $this->request->param('alias');

        $static = Jelly::query('static')->where('alias', '=', $alias)->limit(1)->select();

        if ($static->loaded() AND $static->active)
        {
            $comments = array();

            if($static->cant_comment)
            {
                $comments = Jelly::query('comment')->where('static_id', '=', $static->id())->order_by('date', 'DESC')->pagination()->select_all();
            }

            $this->title($static->title, FALSE);
            $this->view(array('static' => $static, 'comments' => $comments));
        }
        else
        {
            $this->redirect();
        }
    }


    public function action_add()
    {
        if ($this->allowed())
        {
            $this->js('jquery.tinymce.js');

            $static = Jelly::factory('static');

            if ($_POST)
            {
                try
                {
                    $static->set(array(
                        'title' => Arr::get($_POST, 'title'),
                        'alias' => $this->alias($_POST),
                        'active' => Arr::get($_POST, 'active', 0),
                        'cant_comment' => Arr::get($_POST, 'cant_comment', 0),
                        'body' => html_entity_decode(Arr::get($_POST, 'body', ''), ENT_QUOTES)
                    ))->save();
                }
                catch (Jelly_Validation_Exception $e)
                {
                    $this->errors($e->errors('errors'));
                }

                if ($static->saved())
                {
                    $this->redirect(Route::url('static'));
                }
            }
            $this->view()->static = $static;
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


            $static = Jelly::factory('static', $this->request->param('id'));
            if ($static->loaded())
            {
                if ($_POST)
                {
                    try
                    {
                        $static->set(array(
                            'title' => Arr::get($_POST, 'title'),
                            'alias' => $this->alias($_POST),
                            'active' => Arr::get($_POST, 'active', 0),
                            'cant_comment' => Arr::get($_POST, 'cant_comment', 0),
                            'body' => html_entity_decode(Arr::get($_POST, 'body', ''), ENT_QUOTES)
                        ))->save();
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }

                    if ($static->saved())
                    {
                        $this->redirect(Route::url('static'));
                    }
                }
                $this->view()->static = $static;
            }
            else
            {
                $this->redirect(Route::url('static'));
            }
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function action_delete()
    {
        if ( ! $this->allowed())
        {
            $this->redirect();
        }
        Jelly::factory('static')->delete($this->request->param('id'));
        $this->redirect(Route::url('static'));
    }

    protected function alias($post)
    {
        $alias = mb_strtolower(Arr::get($post, 'alias', ''));
        if(preg_match('/[a-z-_\/0-9]+/', $alias, $match))
        {
            $alias = $match[0];
        }
        else
        {
            $alias = Utils::translit(Arr::get($post, 'title'));
        }
        return $alias;
    }
}