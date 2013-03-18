<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
    'hash' => array(
        'default' => array(
            'method' => 'sha1',
            'salt' => '4f8dj30ZXFDFr4'
        ),
	    'recover' => array(
		    'method' => 'sha1',
		    'salt' => '2ero2047dh8er2'
	    ),
    ),
    'rand' => array(
        'default' => array(
            'charset' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
            'length' => 32
        ),
        'image' => array(
            'charset' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
            'length' => 5
        ),
        'password' => array(
            'charset' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
            'length' => 8,
        ),
	    'symbol' => array(
		    'charset' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
		    'length' => 1
	    )
    )

);