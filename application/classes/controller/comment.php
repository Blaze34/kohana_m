<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Web {

    public function action_last()
    {
        $show_count = Kohana::$config->load('comment.last');

        $comments = array_fill(0, $show_count, 'comment');

        $this->view()->comments = $comments;
    }

    public  function action_delete()
    {
        if ($this->allowed())
        {
            if($id = $this->request->param('id'))
            {
                $comment = Jelly::factory('comment', $id);
                if($comment->loaded())
                {
                    $comment->delete();
                }
            }
            else
            {
                $this->errors(__('error.delete'));
            }
        }
        else
        {
            $this->errors(__('global.no_permissons'));
        }

        $this->redirect();
    }
} // End Welcome
