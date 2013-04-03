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

    public function action_delete()
    {
        if ($this->allowed())
        {
            if($id = $this->request->param('id'))
            {
                $comment = Jelly::factory('comment', $id);
                if($comment->loaded())
                {
                    $material = Jelly::factory('material', $comment->material->id())->decrement('comments_count');
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
