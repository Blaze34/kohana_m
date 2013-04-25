<?php defined('SYSPATH') or die('No direct script access.');

class Model_Static extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(

            'id' => Jelly::field('primary'),
            'title' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty')
                ),
                'unique' => TRUE,
                'label' => 'static.field.title'
            )),
			'alias' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty')
                ),
                'unique' => TRUE,
                'label' => 'static.field.alias'
            )),
            'body' => Jelly::field('text', array(
                'rules' => array(
                    array('not_empty')
                ),
                'label' => 'static.field.body'
            )),
			'time_create' => Jelly::field('timestamp', array(
                'auto_now_create' => TRUE
            )),
			'time_update' => Jelly::field('timestamp', array(
                'auto_now_update' => TRUE
            )),
			'active' =>  Jelly::field('boolean', array(
                'default' => FALSE
            )),
            'cant_comment' =>  Jelly::field('boolean', array(
                'default' => TRUE
            ))
		));
	}

    public function get_resource_id()
    {
        return 'static';
    }
}