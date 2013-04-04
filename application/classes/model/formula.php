<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Formula extends Jelly_Model implements Acl_Resource_Interface {

    public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary'),
            'formula' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty')
                ),
                'label' => 'formula.field.title'
            )),
            'name' => Jelly::field('string', array(
                'rules' => array(
                    array('not_empty')
                ),
                'label' => 'formula.field.name'
            )),
		));
	}

    public function get_resource_id()
    {
        return 'formula';
    }
}