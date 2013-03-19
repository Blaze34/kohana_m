<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'name' => Jelly::field('string', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 3)),
					array('max_length', array(':value', 250))
				),
				'label' => 'category.field.name'
			)),
			'sort' => Jelly::field('integer', array(
				'default' => 1
			)),

			'parent_id' => Jelly::field('integer', array(
				'label' => 'category.field.parent'
			)),

			'children' => Jelly::field('hasmany', array(
				'label' => 'category.field.children',
				'foreign' => 'category.parent_id'
			))

		));
	}

    public function get_resource_id()
    {
        return 'category';
    }
}