<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Poll extends Controller_Web {

	public function action_index()
	{
        if ($this->user)
        {
            /*if ($this->request->is_ajax())
            {
                $this->view('/clean')->echo = Utils::json_encode(array('type' => 'success'));
            }*/

            if($act = $this->request->param('act') AND $type = $this->request->param('type') AND $type_id = $this->request->param('id'))
            {
                $value = (bool) ($act == 'like');

                if(Jelly::query($type)->where('id', '=', $type_id)->count())
                {
                    $poll = Jelly::query('poll')
                        ->where('user_id', '=', $this->user->id())
                        ->where('type_id', '=', $type_id)
                        ->where('type', '=', $type)
                        ->limit(1)->select();


                    $material = array();

                    if($type == 'material')
                    {
                        $material = Jelly::factory('material', $type_id);
                    }

                    if($poll->loaded())
                    {
                        if($material->loaded())
                        {
                            $material->update_opinion($value);
                        }
                        $poll->set('value', $value);
                    }
                    else
                    {
                        if($material->loaded())
                        {
                            $material->add_opinion($value);
                        }

                        $poll->set(array(
                            'user' => $this->user->id(),
                            'type_id' => $type_id,
                            'type' => $type,
                            'value' => $value
                        ));
                    }

                    $poll->save();
                    $this->redirect();
                }
                else
                {
                    $this->errors('error.poll.no_exist');
                }
            }
            else
            {
                $this->errors('global.no_params');
            }
        }
        else
        {
            $this->errors('error.vote.unlogin')->redirect();
        }
	}

} // End Welcome
