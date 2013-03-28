<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Holder extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
            'title' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty')
                ),
                'label' => 'holder.field.title'
            )),
            'body' => Jelly::field('text', array(
                'rules' => array(
                    array('not_empty')
                ),
                'label' => 'holder.field.body'
            )),
            'activity' => Jelly::field('boolean', array(
                'default' => false,
                'label' => 'holder.field.activity',
            ))
		));
	}

    public function get_resource_id()
    {
        return 'holder';
    }
}