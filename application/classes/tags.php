<?php defined('SYSPATH') or die('No direct script access.');

class Tags {

	public static function config()
	{
		return Kohana::$config->load('tags');
	}

	protected static function _get($tags, $auto_create = TRUE)
	{
		$exists = Jelly::query('tag')->where('name', 'IN', $tags)->execute()->as_array('name', 'id');

		if ($auto_create)
		{
			$create = array();
			foreach ($tags as $t)
			{
				if ( ! Arr::get($exists, $t))
				{
					$create[] = $t;
				}
			}

			if (sizeof($create))
			{
				DB::query(Database::INSERT, "INSERT INTO `tags` (`name`) VALUES ('".implode("'),('", $create)."')")->execute();
				$created = Jelly::query('tag')->where('name', 'IN', $tags)->execute()->as_array('name', 'id');

				$exists = Arr::merge($created, $exists);
			}
		}

		return $exists;
	}

	protected static function explode_tags()
	{
		$tags = Arr::get($_POST, 'tags', '');
		if ( ! is_string($tags))
			return array();

		$tags = explode(',', $tags);
		$config = self::config();

		$unic_tags = array();
		foreach ($tags as $tag)
		{
			if ($tag = self::_normalize($tag) AND ! in_array($tag, $unic_tags) AND (mb_strlen($tag, 'utf-8') >= $config['min_length']) AND (mb_strlen($tag) < $config['max_length']))
			{
				$unic_tags[] = $tag;
			}
			if (sizeof($unic_tags) >= $config['max_count'])
				break;
		}
		return $unic_tags;
	}

	public static function add($material)
	{
		$new_tags = self::explode_tags();
		if (!sizeof($new_tags))
			return;

		$tags_arr = self::_get($new_tags);
		$inc_id = array();
		foreach ($new_tags as $tag)
		{
			$inc_id[] = $tags_arr[$tag];
		}

		if (sizeof($inc_id))
		{
			$query = DB::insert('materials_tags', array('material_id', 'tag_id'));
			foreach ($inc_id as $id)
			{
				$query->values(array('maretial_id' => $material->id(), 'tag_id' => $id));
			}
			$query->execute();
		}
	}

	public static function delete($material)
	{
		DB::delete('materials_tags')->where('material_id', '=', $material->id())->execute();
	}

	public static function get($material)
	{
		if ($material->id())
		{
			return $material->get('tags')->execute()->as_array('id', 'name');
		}
		return array();
	}

	public static function similar($material, $limit = 5)
	{
        $similar = array();

        $ids = $material->get('tags')->execute()->as_array(NULL, 'id');

		if (sizeof($ids))
		{
			$similar_id = DB::select('material_id')->from('materials_tags')
				->where('tag_id', 'in', $ids)
				->and_where('material_id', '!=', $material->id())
				->group_by('material_id')
				->order_by(DB::expr('COUNT(material_id)'), 'DESC')->limit($limit)->execute()->as_array(NULL, 'material_id');

			if (sizeof($similar_id))
			{
				$similar = array_flip($similar_id);

				$materials = Jelly::query('material')->where('id', 'in', $similar_id)->execute();

				foreach($materials as $m)
				{
					$similar[$m->id()] = $m;
				}
			}
        }
        return $similar;
    }

	public static function update($material)
	{
		$new_tags = self::explode_tags();
		$old_tags = self::get($material);

		if ( ! sizeof($marge_tags = array_unique(array_merge($new_tags, $old_tags))))
			return;

		$tags_arr = self::_get($marge_tags);

		$increase = array_diff($new_tags, $old_tags);
		$removed = array_diff($old_tags, $new_tags);
		$relation = $remove_id = array();
		foreach ($increase as $tag)
		{
			if ($id = Arr::get($tags_arr, $tag))
			{
				$relation[] = $id;
			}
		}
		foreach($removed as $tag)
		{
			if ($id = Arr::get($tags_arr, $tag))
			{
				$remove_id[] = $id;
			}
		}

		if (sizeof($relation))
		{
			$qwery = DB::insert('materials_tags', array('material_id', 'tag_id'));
			foreach ($relation as $id)
			{
				$qwery->values(array('material_id' => $material->id(), 'tag_id' => $id));
			}
			$qwery->execute();
		}

		if(sizeof($remove_id))
		{
			DB::delete('materials_tags')->where('tag_id', 'IN', $remove_id)->and_where('material_id', '=', $material->id())->execute();
		}
	}

	public static function field($material = NULL, $attributes = array())
	{
		$tags = $material ? self::get($material) : array();

		return View::factory('tag/field')->set(array(
			'tags' => Arr::get($_POST, 'tags', implode(',', $tags)),
			'attributes' => $attributes
		))->render();
	}

	protected static function _normalize($tag)
	{
		$tag = preg_replace(array('/[^a-z0-9а-яёіїєґ\-\s]/iu', '/[\s]+/u'), array(' ', ' '), $tag);
		return mb_strtolower(trim($tag));
	}
}