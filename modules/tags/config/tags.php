<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array(
		'max_count' 			=> 3,
		'min_length'			=> 3,
		'max_length'			=> 50,
		'min_repeat'			=> 2,
		'max_count_in_cloud'	=> 30,
		'min_size'				=> 10,
		'max_size'				=> 25,
		'similar'				=> 5,
        'cache'                 => 10800
	)
);