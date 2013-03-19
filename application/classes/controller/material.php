<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Material extends Controller_Web {

	public function action_index()
	{

	}

	public function action_add_video()
	{
		if ($id = $this->request->param('id'))
		{
			$video = Youtube::factory()->find($id);

//			echo Debug::vars($video);
			if ($video)
			{
				$categories = Jelly::query('category')->order_by('parent')->order_by('sort')->select_all();

				$material = Jelly::factory('material');

				$material->set(array(
					'video' => $id,
					'title' => $video->title,
					'description' => $video->description,
					'start' => 0,
					'end' => $video->description
				));

				$this->view()->material = $material;
			}
			else
			{

			}
		}
		else
		{

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
//		$this->error('material.parse.error')->redirect();
	}


} // End Welcome
