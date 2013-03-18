<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Tag_Core extends Kohana_Controller_Template {

	public $template = 'tags/layout';

	public function action_index()
	{
		$id = $this->request->param('id');
		$resource = $this->request->param('resource');
		$res_id = Jelly::select('obj')->select('object_id')
						->join(
							array(
								Jelly::select('obj_tags')
										->select_array(array('id', 'name', 'obj_id'))
										->join('tag', 'INNER')
										->on('id', '=', 'tag_id')
										->where('tag_id', '=', $id),
								't'
							),
							'INNER'
						)
						->on('t.obj_id', '=', 'id')
						->where('object_table', '=', $resource)
						->execute()
						->as_array(NULL, 'object_id');

		$resources = array();
		if(sizeof($res_id))
		{
			$method = 'tag_'.$resource;
			$builder = Jelly::select($resource)->where('id', 'IN', $res_id);
			if (method_exists($builder, $method)){
				$builder->$method();
			}
			$resources = $builder->execute();
		}
		try
		{
			$content = View::factory('tags/'.$resource)->set(array('resources' => $resources, 'resource' => $resource));
		}
		catch (Exception $e)
		{
			$content = View::factory('tags/default')->set(array('resources_id' => $res_id, 'resource' => $resource));
		}
		$this->template->content = $content;
	}
}