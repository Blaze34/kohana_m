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

			if ($file AND Upload::not_empty($file) AND Upload::valid($file) AND  Upload::type($file, $config['extensions']))
			{
				$this->save_gif_from_file($material, $file, $config);
			}
			elseif($url)
			{
				$this->save_gif_from_url($material, $url, $config);
			}
		}

		$this->view(array('category_options' => $category_options, 'material' => $material));
	}

	protected function save_gif_from_url($material, $url, $config)
	{
		if(in_array(pathinfo($url, PATHINFO_EXTENSION), $config['extensions']))
		{
			stream_context_create(array('http'=>array('method'=>'HEAD', 'max_redirects'=>1, 'timeout'=>10)));
			$header = @get_headers($url, 1);

			echo Debug::vars($header);

			if(strpos(Arr::get($header, 0, ''), '200 OK') !== FALSE)
			{
				if( intval(Arr::get($header, 'Content-Length')) <= Num::bytes($config['size']))
				{
					if($tmp_gif = $this->save_tmp_file($url))
					{

						die();

						if( in_array(Arr::get($header, 'Content-Type'), $config['mimes']))
						{
							try
							{
								$material->set(array('file' => $material->get_filename('gif'), 'url' => $url))->save();
							}
							catch(Jelly_Validation_Exception $e)
							{
								$this->errors($e->errors('errors'));
							}

							if ($material->saved())
							{

									$material->save_thumb($tmp_gif);

	//								Tags::add($material);
							}
						}
						else
						{
							$this->errors(__('material.upload.error'));
						}
					}
					else
					{
						$material->delete();
						$this->errors(__('material.upload.error'));
					}
				}
				else
				{
					$this->errors(__('material.upload.too_big'));
				}
			}
			else
			{
				$this->errors(__('material.upload.error'));
			}
		}
		else
		{
			$this->errors(__('material.upload.not_allowed'));
		}
	}

	protected function save_gif_from_file($material, $file, $config)
	{
		if (Upload::size($file, $config['size']))
		{
			if ($_tmp = $this->save_tmp_file($file))
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

					if (copy($_tmp, $dir.$material->file))
					{
						Tags::add($material);

						$material->save_thumb($_tmp);
					}
					else
					{
						$material->delete();
						$this->errors(__('material.upload.error'));
					}
				}
				unlink($_tmp);

				if ($material->saved())
				{
					$this->redirect(Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $material->id())));
				}
			}
		}
		else
		{
			$this->errors(__('material.upload.too_big'));
		}
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
