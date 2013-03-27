<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Menu_Link extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'name' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty'),
                ),
                'label' => 'link.field.name'
            )),

            'url' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty'),
                ),
                'label' => 'link.field.url'
            )),

            'sort' => Jelly::field('integer', array(
                'default' => 1,
                'label' => 'link.field.sort'
            )),

            'menu' => Jelly::field('belongsto', array(
                'label' => 'link.field.menu'
            )),
		));
	}

    public function get_resource_id()
    {
        return 'menu_link';
    }
}