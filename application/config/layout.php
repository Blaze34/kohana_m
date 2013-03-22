<?php

return array(
    'default' => array(
        'layout' => array(
            'main' => 'main',
            'nested' => 'nested',
            'ajax' => 'ajax',
            'print' => 'print'
        ),
        'title' => __('global.title'),
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
                    'jquery/1.8.3.min.js',
	                'bootstrap.min.js',
	                'html5shiv.js',
	                'bootstrap-datepicker.js',
	                'bootstrap-datepicker.ru.js',
	                'global.js',
	                'jquery/noty/noty.js',
	                'jquery/noty/layouts/center.js',
	                'jquery/noty/themes/default.js',
	                'swfobject.js',
                    'jquery/jquery.bxslider.min.js',
                ),
                'css' => array(
                    'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800&subset=latin,cyrillic-ext',
                    'normalize.css',
                    'bootstrap.css',
                    'datepicker.css',
                    'jquery.bxslider.css',
                    'style.css',
                )
            )
        )
    ),

    'auth' => array(
        'layout' => array(
            'main' => 'auth',
            'nested' => 'nested',
            'ajax' => 'ajax',
            'print' => 'print'
        ),
        'title' => __('global.title'),
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
				    'jquery/1.8.3.min.js',
				    'bootstrap.min.js',
			    ),
			    'css' => array(
				    'bootstrap.min.css',
					'datepicker.css',
				    'style.css',
				    'auth.css',
			    )
		    )
	    )
    ),

    'admin' => array(
        'parent' => 'default',
        'layout' => array(
            'main' => 'admin'
        )
    ),

	'error' => array(
		'layout' => array(
			'main' => 'error',
			'nested' => 'nested',
			'ajax' => 'ajax',
			'print' => 'print'
		),
		'title' => __('global.title'),
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
					'jquery/1.8.3.min.js',
					'bootstrap.min.js',
				),
				'css' => array(
					'bootstrap.min.css',
					'style.css'
				)
			)
		)
	)
);