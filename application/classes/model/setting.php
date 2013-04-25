<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Setting extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),

			'name' => Jelly::field('string', array(
                'label' => 'setting.field.name'
            )),

            'title' => Jelly::field('string', array(
                'label' => 'setting.field.name'
            )),

            'status' => Jelly::field('boolean', array(
                'default' => FALSE,
                'label' => 'setting.field.lock_guest',
            )),
		));
	}

    public function get_resource_id()
    {
        return 'setting';
    }
}