<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Poll extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'user' => Jelly::field('belongsto', array(
                'label' => 'like.field.user'
            )),

            'type' => Jelly::field('enum', array(
                'choices' => array('comment', 'material'),
                'label' => 'like.field.type'
            )),

            'type_id' => Jelly::field('integer', array(
                'label' => 'like.field.type_id'
            )),

            'value' => Jelly::field('boolean', array(
                'default' => TRUE,
                'label' => 'like.field.value',
            )),
		));
	}

    public function get_resource_id()
    {
        return 'poll';
    }
}