<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Material extends Controller_Web {

	public function action_index()
	{

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
						if ($thumb)
						{
							if ($_tmp = $this->save_tmp_file($thumb, $material))
							{
								if ( ! $material->save_thumb($_tmp))
								{
									$material->rm_thumb();
								}
								unlink($material->thumb_dir().$_tmp);
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
				$this->error('material.parse.error')->redirect('/');
			}
		}
		else
		{
			$this->error('material.parse.error')->redirect('/');
		}
	}

	public function action_parse()
	{
		$_GET['url'] = 'http://www.youtube.com/watch?v=3CCFufefe9E';

		if ($url = Arr::get($_GET, 'url'))
		{
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
			{

				if ($video_id = Arr::get($match, 1))
				{
					$this->redirect(Route::url('default', array('controller' => 'material', 'action' => 'add', 'id' => $video_id)));
				}
			}
		}
		$this->error('material.parse.error')->redirect();
	}

	public function action_show()
	{
		if ($id = $this->request->param())
		{
			$material = Jelly::factory('material', $id);

			if ($material->loaded())
			{
				$this->title($material->title, FALSE);

				$this->view()->material = $material;
			}
			else
			{
				$this->error('global.no_exist')->redirect('/');
			}
		}
		else
		{
			$this->error('global.no_params')->redirect('/');
		}
	}

	protected function save_tmp_file($file, $material)
	{
		$_dir = $material->thumb_dir();

		if ( ! is_dir($_dir))
		{
			mkdir($_dir);
		}

		if (is_array($file))
		{
			$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			$_tmp = 'tmp_'.$material->id().'.'.$ext;

			if (Upload::save($file, $_tmp, $_dir))
			{
				return $_tmp;
			}
		}
		elseif (is_string($file))
		{
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			$_tmp = 'tmp_'.$material->id().'.'.$ext;

			$_c = file_get_contents($file);

			if ($_c)
			{
				if (file_put_contents($_dir.$_tmp, $_c))
				{
					return $_tmp;
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
