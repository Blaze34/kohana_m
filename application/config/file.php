<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
    'image' => array(
        'default' => 'image.jpg',
        'allowed' => array('jpg', 'jpeg', 'png', 'gif', 'bmp'),
        'as' => 'jpg',
        'size' => '2M',
        'dir' => '../uploads/files/images/',
        'tmp_dir' => '../uploads/tmp/',
        'split' => 1000,
        'limit' => 3,

        'types' => array(

            'full' => array(
                'prefix' => 'full',
                'quality' => 95,
                'do' => NULL
            ),

            'thumb' => array(
                'prefix' => 'thumb',
                'width' => 125,
                'height' => 125,
                'quality' => 95,
                'do' => 'crop'
            ),
        ),
    )
);
