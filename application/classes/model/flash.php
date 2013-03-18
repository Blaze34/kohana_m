<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Flash extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
    {
		$meta->fields(array(
			'id' => Jelly::field('primary'),
            'user' => Jelly::field('belongsto',array(
                'default' => NULL
            )),
            'data' => Jelly::field('serialized'),
			'date' => Jelly::field('timestamp', array(
                'auto_now_create' => TRUE
            ))
		));
    }
} // End Model_Flash