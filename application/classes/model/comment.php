<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Comment extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
			'text' => Jelly::field('text', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 3)),
					array('max_length', array(':value', 850))
				),
                'label' => 'comment.field.text'
			)),

			'user' => Jelly::field('belongsto'),
            'guest_name' => Jelly::field('string', array(
                'label' => 'comment.field.guest_name'
            )),

            'material' => Jelly::field('belongsto'),

            'date' => Jelly::field('timestamp', array(
                'auto_now_create' => TRUE,
                'auto_now_update' => TRUE
            ))
		));
	}

    public function get_resource_id()
    {
        return 'comment';
    }
}