<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Material extends Controller_Web {

	public function action_index()
	{
//        $materials = Jelly::query('material')->with('user')->with('category')->pagination()->select_all();


	}

	public function action_add_video()
	{
		if ($id = $this->request->param('id'))
		{
			if ($video = Youtube::factory()->find($id))
			{
				$material = Jelly::factory('material');

				$material->set(array(
					'video' => $id,
					'title' => $video->title,
					'description' => $video->description,
					'user' => $this->user ? $this->user->id() : NULL
				));
				$category_options = $this->get_category_options();

				$thumb = NULL;

				if (property_exists($video, 'thumbnail') AND ($_t = $video->thumbnail))
				{
					if (property_exists($_t, 'hqDefault'))
					{
						$thumb = $_t->hqDefault;
					}
					elseif (property_exists($_t, 'sqDefault'))
					{
						$thumb = $_t->sqDefault;
					}
				}

				if ($_POST)
				{
					$material->set(array(
						'title' => Arr::get($_POST, 'title'),
						'description' => Arr::get($_POST, 'description'),
						'category' => $this->get_selected_category($category_options),
						'start' => Arr::get($_POST, 'start'),
						'end' => Arr::get($_POST, 'end')
					));

					try
					{
						$material->save();
					}
					catch (Jelly_Validation_Exception $e)
					{
						$this->errors($e->errors('errors'));
					}

					if ($material->saved())
					{
						Tags::add($material);

						if ($thumb)
						{
							if ($_tmp = $this->save_tmp_file($thumb))
							{
								if ( ! $material->save_thumb($_tmp))
								{
									$material->rm_thumb();
								}
								unlink($_tmp);
							}
						}

						$this->redirect(Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $material->id())));
					}
				}

				$this->view()->material = $material;
				$this->view()->category_options = $category_options;
			}
			else
			{
				$this->errors('material.parse.error')->redirect('/');
			}
		}
		else
		{
			$this->errors('global.no_params')->redirect('/');
		}
	}

	public function action_parse()
	{
//		$_GET['url'] = 'http://www.youtube.com/watch?v=3CCFufefe9E';

		if ($url = Arr::get($_GET, 'url'))
		{
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
			{

				if ($video_id = Arr::get($match, 1))
				{
					$this->redirect(Route::url('default', array('controller' => 'material', 'action' => 'add_video', 'id' => $video_id)));
				}
			}
		}
		$this->errors('material.parse.error')->redirect();
	}

	public function action_add_gif()
	{
		$config = Kohana::$config->load('material.gif');

		$material = Jelly::factory('material');
		$category_options = $this->get_category_options();

		if($_POST)
		{
			$url = Arr::get($_POST, 'url');
			$file = Arr::get($_FILES, 'gif');

			$material->set(array(
				'title' => Arr::get($_POST, 'title'),
				'description' => Arr::get($_POST, 'description'),
				'category' => $this->get_selected_category($category_options),
				'user' => $this->user ? $this->user->id() : NULL
			));


			$tmp_file = NULL;

			if ($file AND Upload::not_empty($file) AND Upload::valid($file))
			{
				if ($tmp_file = $this->save_gif_from_file($file, $config))
				{
					$url = '';
				}
			}

			if($url)
			{
				$tmp_file = $this->save_gif_from_url($url, $config);
			}

			if ($tmp_file)
			{
				try
				{
					$material->save();
				}
				catch(Jelly_Validation_Exception $e)
				{
					$this->errors($e->errors('errors'));
				}

				if ($material->saved())
				{
					$dir = $material->dir('gif');
					if ( ! is_dir($dir))
					{
						mkdir($dir);
					}

					$material->set('file', $material->get_filename('gif'))->save();

					if (copy($tmp_file, $dir.$material->file))
					{
						Tags::add($material);

						$material->save_thumb($tmp_file);
					}
					else
					{
						$material->delete();
					}
				}
				unlink($tmp_file);

				if ($material->saved())
				{
					$this->redirect(Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $material->id())));
				}
				else
				{
					$this->errors('material.upload.error');
				}
			}
		}

		$this->view()->category_options = $category_options;
	}

	protected function save_gif_from_url($url, $config)
	{
		if(in_array(pathinfo($url, PATHINFO_EXTENSION), $config['extensions']))
		{
			stream_context_create(array('http'=>array('method'=>'HEAD', 'max_redirects'=>1, 'timeout'=>10)));
			$header = @get_headers($url, 1);

			if(strpos(Arr::get($header, 0, ''), '200 OK') !== FALSE)
			{
				if( intval(Arr::get($header, 'Content-Length')) <= Num::bytes($config['size']))
				{
					if($tmp_gif = $this->save_tmp_file($url))
					{
						if( in_array(Arr::get($header, 'Content-Type'), $config['mimes']))
						{
							return $tmp_gif;
						}
						unlink($tmp_gif);
					}
				}
			}
		}

		return FALSE;
	}

	protected function save_gif_from_file($file, $config)
	{
		if (Upload::size($file, $config['size']) AND Upload::type($file, $config['extensions']))
		{
			if ($info = getimagesize($file['tmp_name']))
			{
				if( in_array(Arr::get($info, 'mime'), $config['mimes']))
				{
					if ($_tmp = $this->save_tmp_file($file))
					{
						return $_tmp;
					}
				}
			}
		}

		return FALSE;
	}

	public function action_show()
	{
		if ($id = $this->request->param())
		{
			$material = Jelly::query('material')->with('category')->where('id', '=', $id)->limit(1)->select();

			if ($material->loaded())
			{
                if($_POST)
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
                            $comment->set(array(
                                'material' => $material->id(),
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

                $this->title($material->title, FALSE);

                $comments = $material->get('comments')->with('user')->order_by('date', 'DESC')->pagination('comments')->select_all();

                list($material_user_vote, $mpoll) = $this->get_material_votes ($id, $material);

                list($cpoll, $comments_user_vote) = $this->get_votes_comments ($comments);

                $this->view(array(
                    'material' => $material,
                    'comments' => $comments,
                    'similar' => $this->get_similar($material),
                    'mpoll' => $mpoll,
                    'cpoll' => $cpoll,
                    'material_user_vote' => $material_user_vote,
                    'comments_user_vote' => $comments_user_vote,
                ));

			}
			else
			{
				$this->errors('global.no_exist')->redirect('/');
			}
		}
		else
		{
			$this->errors('global.no_params')->redirect('/');
		}
	}

    private  function get_material_votes ($id, $material)
    {
        if ($id AND sizeof($material))
        {
            $material_poll = $mpoll = $material_user_vote = array();

            $material_poll = Jelly::query ('poll')
                ->select_column (array(array(DB::expr ('COUNT(id)'), 'count'), 'value'))
                ->where ('type_id', '=', $id)
                ->where ('type', '=', $material->get_resource_id ())
                ->group_by ('value')
                ->select_all ()->as_array ('value', 'count');

            if (sizeof($material_poll))
            {

                $material_user_vote = Jelly::query ('poll')
                    ->where ('user_id', '=', $this->user->id ())
                    ->where ('type_id', '=', $id)
                    ->where ('type', '=', $material->get_resource_id ())
                    ->limit (1)
                    ->select ();

                $mpoll = array(
                    'dislike' => Arr::get ($material_poll, '0', 0),
                    'like' => Arr::get ($material_poll, '1', 0)
                );
            }

            return array($material_user_vote, $mpoll);
        }

        return false;
    }

    protected function get_votes_comments ($comments)
    {
        $ids = $cpoll = $comments_user_vote = array();
        foreach ($comments as $c)
        {
            $ids[] = $c->id ();
        }

        if (sizeof ($ids))
        {
            $comment_poll = Jelly::query ('poll')
                ->select_column (array(array(DB::expr ('COUNT(id)'), 'count'), 'type_id', 'value'))
                ->where ('type_id', 'IN', $ids)
                ->where ('type', '=', Jelly::factory ('comment')->get_resource_id ())
                ->group_by ('type_id', 'value')
                ->select_all ()->as_array ();

            $comments_user_vote_db = Jelly::query ('poll')
                ->select_column (array('value', 'type_id'))
                ->where ('type_id', 'IN', $ids)
                ->where ('user_id', '=', $this->user->id ())
                ->where ('type', '=', Jelly::factory ('comment')->get_resource_id ())
                ->select_all ()->as_array ('type_id', 'value');

            foreach ($comment_poll as $item)
            {
                if ($item['value'])
                {
                    $cpoll[$item['type_id']]['like'] = $item['count'];
                }
                else
                {
                    $cpoll[$item['type_id']]['dislike'] = $item['count'];
                }
            }

            if (sizeof ($comments_user_vote_db))
            {
                foreach ($comments_user_vote_db as $id => $value)
                {
                    $comments_user_vote[$id][$value ? 'like' : 'dislike'] = TRUE;
                }
            }
        }

        return array($cpoll, $comments_user_vote);
    }

    public function action_user()
    {
        if($uid = $this->request->param('id'))
        {
            $user = Jelly::query('users')->where('id', '=', $uid)->limit(1)->select();

            if(sizeof($user))
            {
                $materials = Jelly::query('material')->where('user', '=', $uid)->pagination()->select_all();

                $mids = array();

                foreach ($materials as $m)
                {
                    $mids[] = $m->id();
                }

                if($materials)
                {
                    $comments = Jelly::query('comment')
                        ->with('material')
                        ->select_column(array(array(DB::expr('COUNT(comments.id)'), 'count')))
                        ->group_by('material_id')
                        ->select_all()->as_array('material');

                    if (sizeof($comments))
                    {
                        $polls_arr = Jelly::query('poll')
                            ->select_column(array(array(DB::expr('COUNT(id)'), 'count'), 'type_id', 'value'))
                            ->where('type', '=', Jelly::factory('material')->get_resource_id())
                            ->where('type_id', 'IN', $mids)
                            ->group_by('type_id', 'value')
                            ->select_all()->as_array();

                        if(sizeof($polls_arr))
                        {
                            foreach ($polls_arr as $item)
                            {
                                if ($item['value'])
                                {
                                    $polls[$item['type_id']]['like'] = $item['count'];
                                }
                                else
                                {
                                    $polls[$item['type_id']]['dislike'] = $item['count'];
                                }
                            }
                        }
                    }
                }

                $this->view()->materials = $materials;
                $this->view()->owner = $user;
                $this->view()->comments = $comments;
                $this->view()->polls = $polls;
            }
            else
            {
                $this->errors('global.no_exist')->redirect('/');
            }
        }
        else
        {
            $this->errors('global.no_params')->redirect('/');
        }
    }

    public function action_popular()
    {
        $materials = Jelly::query('material')->pagination()->select_all();

        $mids = array();

        foreach ($materials as $m)
        {
            $mids[] = $m->id();
        }

        if($materials)
        {
            $comments = Jelly::query('comment')
                ->with('material')
                ->select_column(array(array(DB::expr('COUNT(comments.id)'), 'count')))
                ->group_by('material_id')
                ->select_all()->as_array('material');

            if (sizeof($comments))
            {
                $polls_arr = Jelly::query('poll')
                    ->select_column(array(array(DB::expr('COUNT(id)'), 'count'), 'type_id', 'value'))
                    ->where('type', '=', Jelly::factory('material')->get_resource_id())
                    ->where('type_id', 'IN', $mids)
                    ->group_by('type_id', 'value')
                    ->select_all()->as_array();

                if(sizeof($polls_arr))
                {
                    foreach ($polls_arr as $item)
                    {
                        if ($item['value'])
                        {
                            $polls[$item['type_id']]['like'] = $item['count'];
                        }
                        else
                        {
                            $polls[$item['type_id']]['dislike'] = $item['count'];
                        }
                    }
                }
            }
        }

        $this->view()->materials = $materials;
        $this->view()->comments = $comments;
        $this->view()->polls = $polls;
    }

    protected function get_similar($material)
    {
        $similar_materials_by_tags = Tags::similar($material);

        $output = $votes = array();

        if (sizeof($similar_materials_by_tags))
        {
//            $similar = Jelly::query('material')
//                ->where('id', 'IN', $similar_ids)
//                ->select_all();

            $similar = $similar_materials_by_tags;
        }
        else
        {
            $similar = Jelly::query('material')
                ->where('category', '=', $material->category->id())
                ->where('id', '!=', $material->id())
                ->limit(5)->select_all();

            if (! sizeof($similar))
            {
                $similar = Jelly::query('material')
                    ->where('id', '!=', $material->id())
                    ->order_by('date', 'DESC')
                    ->limit(5)->select_all();
            }
        }

        if(sizeof($similar))
        {
            foreach ($similar as $s)
            {
                $sids[] = $s->id();
            }

            $polls_arr = Jelly::query('poll')
                ->select_column(array(array(DB::expr('COUNT(id)'), 'count'), 'type_id', 'value'))
                ->where('type', '=', Jelly::factory('material')->get_resource_id())
                ->where('type_id', 'IN', $sids)
                ->group_by('type_id', 'value')
                ->select_all()->as_array();

            if(sizeof($polls_arr))
            {
                foreach ($polls_arr as $item)
                {
                    if ($item['value'])
                    {
                        $votes[$item['type_id']]['like'] = $item['count'];
                    }
                    else
                    {
                        $votes[$item['type_id']]['dislike'] = $item['count'];
                    }
                }
            }
        }


        return $output = array('similar' => $similar, 'votes' => $votes);
    }

	protected function save_tmp_file($file)
	{
		$_dir = Kohana::$config->load('material.tmp_dir');

		if ( ! is_dir($_dir))
		{
			mkdir($_dir);
		}

		if (is_array($file))
		{
			$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			$_tmp = 'tmp_'.Utils::rand('image').'.'.$ext;

			if (Upload::save($file, $_tmp, $_dir))
			{
				return $_dir.$_tmp;
			}
		}
		elseif (is_string($file))
		{
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			$_tmp = 'tmp_'.Utils::rand('image').'.'.$ext;

			if ($_c = file_get_contents($file))
			{
				if (file_put_contents($_dir.$_tmp, $_c))
				{
					return $_dir.$_tmp;
				}
			}
		}

		return FALSE;
	}

	protected function get_selected_category($category_options)
	{
		$category = NULL;
		if ($_cat = Arr::get($_POST, 'category'))
		{
			foreach($category_options as $ggroup => $options)
			{
				foreach ($options as $k => $v)
				{
					if ($k == $_cat)
					{
						$category = $k;
						break 2;
					}
				}
			}
		}

		return $category;
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
