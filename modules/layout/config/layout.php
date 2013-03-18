<?php

return array(
    'default' => array(
        'layout' => array(
            'main' => 'main',
            'nested' => 'nested',
            'ajax' => 'ajax',
        ),
        'title' => 'Default title',
        'dir' => 'layouts/',

        'css' => array(
		    'path'   => 'web/css/'
	    ),

        'js' => array(
		    'path'   => 'web/js/'
    	),

        'load' => array(
            'main' => array(
                'js' => array(
                    // jQuery common plugins
                ),
                'css' => array(
                    '',
                )
            )
        )
    ),
);