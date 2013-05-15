<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends Jelly_Model implements Acl_Resource_Interface {

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
				'label' => 'category.field.name'
			)),

            'meta_title' => Jelly::field('string', array(
                'default' => NULL,
                'label' => 'category.field.meta_title'
            )),

            'mask_title' => Jelly::field('string', array(
                'default' => NULL,
                'label' => 'category.field.mask_title'
            )),

            'meta_desc' => Jelly::field('string', array(
                'default' => NULL,
                'label' => 'category.field.meta_desc'
            )),

			'sort' => Jelly::field('integer', array(
				'default' => 1
			)),

			'parent_id' => Jelly::field('integer', array(
				'label' => 'category.field.parent'
			)),

            'materials' => Jelly::field('manytomany', array(
                'label' => 'category.field.materials',
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