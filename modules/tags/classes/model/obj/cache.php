<?php defined('SYSPATH') or die('No direct script access.');

class Model_Obj_Cache extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
				'obj_id' => new Field_Primary,
				'cache' => new Field_Serialized
		));
	}
}