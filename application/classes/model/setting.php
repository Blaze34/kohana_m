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
                'label' => 'setting.field.title'
            )),

            'status' => Jelly::field('boolean', array(
                'default' => FALSE,
                'label' => 'setting.field.status',
            )),

            'form' => Jelly::field('boolean', array(
                'default' => FALSE,
                'label' => 'setting.field.form',
            )),

            'value' => Jelly::field('string', array(
                'default' => NULL,
                'label' => 'setting.field.value',
            )),

            'help' => Jelly::field('string', array(
                'default' => NULL,
                'label' => 'setting.field.help',
            )),
		));
	}

    public function get_resource_id()
    {
        return 'setting';
    }
}