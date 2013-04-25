<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Web {

    public function action_last()
    {
        if (Request::current()->is_initial())
        {
            $this->redirect('/');
        }
        else
        {
            $count = Kohana::$config->load('comment.last.count');
            $this->view()->comments = Jelly::query('comment')->with('material')->with('user')->order_by('date', 'DESC')->limit($count)->execute();
        }
    }

    public function action_add()
    {
        if($this->settings['lock_guest_cmnt'])
        {
            if( ! $this->user)
            {
                $this->errors('error.lock_guest')->redirect('');
            }
        }

        if ($id = $this->request->param('id') AND $type = $this->request->param('type'))
        {
            $model = array();

            if($type == 'static')
            {
                $model = Jelly::factory('static', $id);
            }
            elseif($type == 'material')
            {
                $model = Jelly::factory('material', $id);
            }

            if($model->loaded())
            {
                $comment = Jelly::factory('comment');

                $extra_validation = NULL;

                if($this->user OR Captcha::valid(Arr::get($_POST,'captcha')))
                {
                    if($this->user)
                    {
                        $comment->user = $this->user;
                    }
                    else
                    {
                        $comment->guest_name = Arr::get($_POST, 'guest_name');

                        $extra_validation = Validation::factory($_POST)
                            ->rule('guest_name', 'not_empty')
                            ->rule('guest_name', 'min_length', array(':value', 3))->labels(array('guest_name' => 'comment.field.guest_name'));
                    }

                    try
                    {
                        if($type == 'material')
                        {
                            $model->increment('comments_count');
                        }

                        $comment->set(array(
                            $model->get_resource_id() => $model->id(),
                            'text' => Arr::get($_POST, 'text', ''),
                        ))->save($extra_validation);

                        if($comment->saved())
                        {
                            $this->redirect();
                        }
                    }
                    catch (Jelly_Validation_Exception $e)
                    {
                        $this->errors($e->errors('errors'));
                    }
                }
                else
                {

                    $this->errors('error.captcha');
                }
            }
        }
    }

    public function action_delete()
    {
        if ($this->allowed())
        {
            if($id = $this->request->param('id') AND $type = $this->request->param('type'))
            {
                $comment = Jelly::factory('comment', $id);

                if($comment->loaded())
                {

                    if($type == 'material')
                    {
                        $material = Jelly::factory('material', $comment->material->id())->decrement('comments_count');
                    }

                    $comment->delete();
                }
            }
            else
            {
                $this->errors(__('error.no_params'));
            }
        }
        else
        {
            $this->errors(__('global.no_permissons'));
        }

        $this->redirect();
    }
} // End Welcome
