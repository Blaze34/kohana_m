<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tag extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'name' => Jelly::field('string', array(
				'rules' => array(
					'not_empty' => NULL
				)
			)),
			'checked' => Jelly::field('primary', array(
				'default' => TRUE
			))
		));
	}
}