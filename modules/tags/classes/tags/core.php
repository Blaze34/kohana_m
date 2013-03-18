<?php defined('SYSPATH') or die('No direct script access.');

abstract class Tags_Core {

	public static function config($name=NULL)
	{
		if ($name) $config = Kohana::config('tags.'.$name) ? Kohana::config('tags.'.$name) : array();
		return isset($config) ? array_merge(Kohana::config('tags.default'), $config) : Kohana::config('tags.default');
	}

	protected static function _get($tags)
	{
		return Jelly::select('tag')->where('name', 'IN', $tags)->execute()->as_array('name', 'id');
	}

	protected static function _get_obj_tags($obj)
	{
		$cache = $obj->cache('tags');
		return Arr::get($cache, 'id', array());
	}

	protected static function explode_tags($model)
	{
		$tags = Arr::get($_POST, 'tags', array());
		if ( ! is_array($tags) OR ! sizeof($tags))
			return array();
		$resource = self::get_resource($model);
		$config = self::config($resource);

		$unic_tags = array();
		foreach ($tags as $tag)
		{
			if ($tag = mb_strtolower(trim($tag)) AND ! in_array($tag, $unic_tags) AND (mb_strlen($tag) >= $config['min_length']) AND (mb_strlen($tag) < $config['max_length']))
			{
				$unic_tags[] = $tag;
			}
			if (sizeof($unic_tags) >= $config['max_count'])
				break;
		}
		return $unic_tags;
	}

	public static function add($model, $key = NULL)
	{
		$new_tags = self::explode_tags($model);
		if (!sizeof($new_tags))
			return;

		if ($obj = Obj::get($model, $key))
		{
			$tags_arr = self::_get($new_tags);
			echo Kohana::debug($tags_arr);
			$inc_id = array();
			foreach ($new_tags as $tag)
			{
				$inc_id[] = $tags_arr[$tag];
			}
			if (sizeof($inc_id))
			{
				$query = DB::insert('obj_tags', array('obj_id', 'tag_id'));
				foreach ($inc_id as $id)
				{
					$query->values(array('obj_id' => $obj->id, 'tag_id' => $id));
				}
				$query->execute();
			}
			Obj::cache('tags', $obj, array('id' => array_flip($tags_arr), 'tags_names' => $new_tags));
		}
	}

	public static function cloud($model = NULL)
	{
        $resource = NULL;
        if ($model)
        {
            $resource = self::get_resource($model);
        }

        $config = self::config($resource);

        $tags = DB::select('tag_id', 'name', DB::expr('COUNT(*) as count'))->from('obj_tags')
                ->join('tags', 'inner')->on('id', '=', 'tag_id');
        if ($resource)
        {
            $tags->join('objs', 'inner')->on('obj_id', '=', 'objs.id')->on('object_table', '=', DB::expr('"'.$resource.'"'));
        }
        $tags->group_by('tag_id');

        if ($config['min_repeat']>1)
        {
            $tags->having('count', '>=', $config['min_repeat']);
        }

        $tags->limit($config['max_count_in_cloud'])->cached($config['cache']);


        $tags = $tags->execute()
			->as_array();

		if (sizeof($tags))
		{
			$counts = array();
			$min = $max = $tags[0]['count'];
			foreach($tags as $tag)
			{
				$counts[] = $tag['count'];
			}
			$counts = array_unique($counts);
			sort($counts, SORT_NUMERIC);
			$counts = array_flip($counts);
			$max = sizeof($counts) - 1;

			foreach ($counts as $total => $ind)
			{
				if ($max == 0)
				{
					$counts[$total] = $config['max_size'];
				}
				else
				{
					$counts[$total] = round(($config['max_size'] - $config['min_size']) / $max * $ind + $config['min_size']);
				}
			}
			shuffle($tags);
			return View::factory('cloud')->set(array('tags' => $tags, 'counts' => $counts, 'resource' => $resource))->render();
		}
	}

	public static function delete($model, $key = NULL)
	{
		if ($obj = Obj::get($model, $key))
		{
			DB::delete('obj_tags')->where('obj_id', '=', $obj->id)->execute();
		}
	}

	public static function get($model, $key = NULL)
	{
		if ($obj = Obj::get($model, $key))
		{
			return self::_get_obj_tags($obj->id);
		}
		return array();
	}

	public static function get_resource($model)
	{
		if ($model instanceof Model_Obj)
			$resource = $model->table;

		if ($model instanceof Jelly_Model)
		{
			$resource = method_exists($model, 'get_resource_id') ? $model->get_resource_id() : 'undefined_resource';
		}
		elseif (is_string($model))
		{
			$resource = $model;
		}
		return $resource;
	}

	public static function similar($model, $key = NULL)
    {
        if ($obj = Obj::get($model, $key))
        {
			$tags = self::_get_obj_tags($obj);
            if (sizeof($tags))
            {
                $id = array();
                foreach ($tags as $key => $value)
                {
                    $id[] = $key;
                }
				$resource = self::get_resource($model);
				$config = self::config($resource);
                $similar_id = DB::select('objs.object_id')->from('obj_tags')->join('objs')->on('obj_tags.obj_id', '=', 'objs.id')
                        ->where('tag_id', 'in', $id)
                        ->and_where('objs.id', '!=', $obj->id)
                        ->and_where('objs.object_table', '=', $resource)
                        ->group_by('obj_id')
                        ->order_by(DB::expr('COUNT(obj_id)'), 'DESC')->limit($config['similar'])->execute()->as_array(NULL, 'object_id');
                if (sizeof($similar_id))
                {
                    $similar = array_flip($similar_id);

					$builder_method = 'similar_'.$resource;
					$builder = Jelly::select($resource)->where('id', 'in', $similar_id);
					if (method_exists($builder, $builder_method)){
						$builder->$builder_method();
					}
					$similar_res = $builder->execute();

                    foreach($similar_res as $res)
                    {
                        $similar[$res->id] = $res;
                    }

                    try
                    {
                        return View::factory('similar/'.$resource)->set(array('similar' => $similar, 'resource' => $resource))->render();
                    }
                    catch (Exception $e)
                    {
                        return View::factory('similar/default')->set(array('similar' => $similar, 'resource' => $resource))->render();
                    }
                }
            }
        }
    }

	public static function show($model, $sep = ',', $key = NULL)
	{
        if ($obj = Obj::get($model, $key))
		{
            $tags = $obj->cache('tags');
			if ($count = sizeof(Arr::get($tags, 'id'))){
				$resource = $obj->table;
				return View::factory('tags/show')->set(array('tags' => $tags['id'], 'resource' => $resource, 'count' => $count, 'sep' => $sep))->render();
			}
		}
	}

	public static function update($model, $key = NULL)
	{
		$obj = Obj::get($model, $key);
		$new_tags = self::explode_tags($model);
		$old_tags = self::_get_obj_tags($obj);

        if ( ! sizeof($marge_tags = array_unique(array_merge($new_tags, $old_tags))))
            return;
        
		$tags_arr = self::_get($marge_tags);
		
		$increase = array_diff($new_tags, $old_tags);
		$removed = array_diff($old_tags, $new_tags);
		$relation = $remove_id = array();
		foreach ($increase as $tag)
		{
			$relation[] = $tags_arr[$tag];
		}
		foreach($removed as $tag)
		{
			$remove_id[] = $tags_arr[$tag];
		}
		if (sizeof($relation))
		{
			$qwery = DB::insert('obj_tags', array('obj_id', 'tag_id'));
			foreach ($relation as $id)
			{
				$qwery->values(array('obj_id' => $obj->id, 'tag_id' => $id));
			}
			$qwery->execute();
		}
		if(sizeof($remove_id))
		{
			DB::delete('obj_tags')->where('tag_id', 'IN', $remove_id)->and_where('obj_id', '=', $obj->id)->execute();
		}
		$tmp = array();
		foreach($new_tags as $new)
		{
			$tmp[$tags_arr[$new]] = $new;
		}
		$save = sizeof($new_tags) ? array('id' => $tmp, 'tags_names' => $new_tags) : NULL;
		Obj::cache('tags', $obj, $save);
	}

	public static function create($model, $return_old = FALSE)
	{
		$config = self::config(self::get_resource($model));
		$in = Arr::get($_POST, 'tag', '');
		$tags = array();
		foreach (explode(',' , $in) as $t)
		{
			$t = preg_replace(array('/[^a-z0-9а-яёіїєґ\-\s]/iu', '/[\s]+/u'), array(' ', ' '), $t);
			$t = mb_strtolower(trim($t));
			if((mb_strlen($t) >= $config['min_length']) AND (mb_strlen($t) < $config['max_length']))
			{
				$tags[] = $t;
			}
		}
		if (sizeof($tags))
		{
			$tag_in_db = Jelly::select('tag')->where('name', 'IN', $tags)->execute()->as_array(NULL, 'name');
			$diff = array_diff($tags, $tag_in_db);
			if (sizeof($diff))
			{
				DB::query(Database::INSERT, "INSERT INTO `tags` (`name`) VALUES ('".implode("'),('", $diff)."')")->execute();
			}
			return $return_old ? $tags : $diff;
		}
		return array();
	}

	public static function form($model, $key = NULL, $attributes = array())
	{
		$cache = array();
		if ($obj = Obj::get($model, $key))
		{
			$cache = $obj->cache('tags');
		}

		return View::factory('tag/field')->set(array(
            'resource' => self::get_resource($model),
            'tags' => Arr::get($_POST, 'tags') ? Arr::get($_POST, 'tags') : Arr::get($cache, 'id'),
            'attributes' => $attributes
        ))->render();
	}
}