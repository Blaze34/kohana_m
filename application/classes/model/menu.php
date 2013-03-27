<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Menu extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'name' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty'),
                ),
                'label' => 'menu.field.name'
            )),

            'links' => Jelly::field('hasmany', array(
                'foreign' => 'menu_link',
                'label' => 'menu.field.links'
            ))
		));
	}

    public function get_resource_id()
    {
        return 'menu';
    }
}