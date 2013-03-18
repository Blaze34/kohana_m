<?php defined('SYSPATH') or die('No direct script access.');

class Model_Static_Body extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary,
            'lang' => new Field_Enum(array(
                'default' => 'ru',
                'choices' => array('ru', 'ua')
             )),
            'title' => new Field_String(array(
                'rules' => array(
                        'not_empty' => NULL
                )
			)),
            'text' => new Field_Markitup(array(
                'set' => 'bbcode',
                'skin' => 'simple',
                'rules' => array(
                    'not_empty' => NULL
                ),
                'label' => 'fields.static.text_ru'
            )),
            'static' => new Field_BelongsTo,
        ));
	}
}