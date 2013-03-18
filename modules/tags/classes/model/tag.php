<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tag extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
				'id' => new Field_Primary,
				'name' => new Field_String(array(
						'rules' => array(
								'not_empty' => NULL
						)
				)),
				'checked' => new Field_Boolean(array(
					'default' => FALSE
				))
			));
	}
}