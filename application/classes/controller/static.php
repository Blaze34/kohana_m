<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Static extends Controller_Web {

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
        $static = Jelly::select('static')->where('alias', '=', $alias)->with_body()->load();
        if ($static->loaded() AND sizeof($static->langs) AND $static->active)
        {

            $body = $static->body->loaded() ? $static->body : $static->get('bodies')->load();
            $this->meta($body->title);
            $this->speedbar(array($body->title => Route::url('static_view', array('alias' => $static->alias))));
            $this->view()->static = $static;
            $this->view()->body = $body;
        }
        else
        {
            $this->redirect();
        }
    }

    public function action_get()
    {
        if (Request::instance() != Request::current())
        {
            $alias = $this->request->param('alias');
            $static = Jelly::select('static')->where('alias', '=', $alias)->with_body()->load();
            if ($static->loaded() AND sizeof($static->langs) AND $static->active)
            {
                $body = $static->body->loaded() ? $static->body : $static->get('bodies')->load();
                $this->view()->static = $static;
                $this->view()->body = $body;
            }
        }
    }



    public function action_add()
    {
        if ($this->allowed())
        {
            $static = Jelly::factory('static');
            if ($_POST)
            {
                try
                {
                    $static->alias = $this->alias($_POST);
                    $static->active = Arr::get($_POST, 'active', 0);
                    $static->body = html_entity_decode(Arr::get($_POST, 'body', ''), ENT_QUOTES);
                }
                catch (Validate_Exception $e)
                {
                    $this->errors($e->array->errors('validate'));
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
            $static = Jelly::select('static')->load($this->request->param('id'));
            if ($static->loaded())
            {
                $body_model = Jelly::factory('static_body');
                $need_langs = array_diff($body_model->meta(NULL)->fields('lang')->choices, is_array($static->langs) ? $static->langs : array() );

                if ($_POST)
                {
                    try
                    {
                        $langs = array();
                        if (Arr::get($_POST, 'update'))
                        {
                            foreach($static->bodies as $body)
                            {
                                if ($_body = Arr::get($_POST['update'], $body->id()))
                                {
                                    $body->set(Arr::extract($_body, array('title', 'text')));
                                    $body->text = html_entity_decode($body->text, ENT_QUOTES);

                                    if ($body->changed())
                                    {
                                        try
                                        {
                                            $body->save();
                                            $langs[] = $body->lang;
                                        }
                                        catch (Validate_Exception $e)
                                        {
                                            $body->delete(NULL);
                                        }
                                    }
                                    else
                                    {
                                        $langs[] = $body->lang;
                                    }
                                }
                            }
                        }

                        if (Arr::get($_POST, 'create'))
                        {
                            foreach($need_langs as $lang)
                            {
                                if ($_body = Arr::get($_POST['create'], $lang))
                                {
                                    $body = Jelly::factory('static_body', Arr::extract($_body, array('title', 'text')));
                                    $body->text = html_entity_decode($body->text, ENT_QUOTES);
                                    $body->lang = $lang;
                                    try
                                    {
                                        $body->set('static', $static->id());
                                        $body->save();
                                        $langs[] = $body->lang;
                                    }
                                    catch (Validate_Exception $e)
                                    {
                                    }
                                }
                            }
                        }


                        $static->set(array('alias' => $this->alias($_POST), 'langs' => $langs, 'active' => Arr::get($_POST, 'active', 0)))->save();
                        $this->redirect(Route::url('static'));
                    }
                    catch (Validate_Exception $e)
                    {
                        $this->errors($e->array->errors('validate'));
                    }
                }
                $this->view('/admin/static/edit')->static = $static;
                $this->view()->body = $body_model;
                $this->view()->need_langs = $need_langs;
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