<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Material extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'title' => Jelly::field('string', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 3)),
					array('max_length', array(':value', 250))
				),
				'label' => 'material.field.title'
			)),
			'category' => Jelly::field('belongsto', array(
				'rules' => array(
					array('not_empty'),
				),
				'label' => 'material.field.category'
			)),
			'description' => Jelly::field('text', array(
				'label' => 'material.field.description'
			)),

			'duration' => Jelly::field('integer', array(
				'in_db' => FALSE
			)),

			'start' => Jelly::field('integer', array(
				'default' => NULL
			)),
			'end' => Jelly::field('integer', array(
				'default' => NULL
			)),

			'rating' => Jelly::field('integer', array(
				'default' => 0
			)),

			'user' => Jelly::field('belongsto', array(
				'label' => 'material.field.user'
			)),

			'video' => Jelly::field('string'),
			'file' => Jelly::field('string'),

			'tags' => Jelly::field('manytomany')
		));
	}

    public function get_resource_id()
    {
        return 'material';
    }
}