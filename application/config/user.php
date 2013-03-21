<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'filter'       => array(
		'username' => array(
			'condition' => 'LIKE',
			'type' => 'text',
			'suffix' => '%'
		),
		'firstname' => array(
			'condition' => 'LIKE',
			'type' => 'text',
			'suffix' => '%'
		),
		'lastname' => array(
			'condition' => 'LIKE',
			'type' => 'text',
			'suffix' => '%'
		),
		'email' => array(
			'condition' => 'LIKE',
			'type' => 'text',
			'suffix' => '%'
		)
	),
	'avatar' => array(
		'default' => 'no_avatar.png', // link
		'allowed' => array('jpg', 'jpeg', 'png', 'gif', 'bmp'),
		'as' => 'jpg',
		'size' => '2M',
		'dir' => 'uploads/avatars/',
		'split' => 1000,
		'hash' => 'sha1',
		'salt' => '4dsr5dfy3@$Fd',

		'types' => array( // don't allowed tmp_ prefix
			'full' => array(
				'prefix' => 'f',
				'postfix' => '',
				'width' => 900,
				'height' => 900,
				'quality' => 90,
				'do' => 'resize'
			),

			'medium' => array(
				'prefix' => 'm',
				'postfix' => '',
				'width' => 200,
				'height' => 200,
				'quality' => 100,
				'do' => 'crop'
			),

			'thumb' => array(
				'prefix' => 't',
				'postfix' => '',
				'width' => 48,
				'height' => 48,
				'quality' => 100,
				'do' => 'crop'
			),
		),
	),
);
