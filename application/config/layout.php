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
	                'jquery/tmpl.min.js',
	                'bootstrap.min.js',
	                'bootstrap-datepicker.js',
	                'bootstrap-datepicker.ru.js',
	                'global.js',
	                'jquery/noty/noty.js',
	                'jquery/noty/layouts/center.js',
	                'jquery/noty/themes/default.js',
                ),
                'css' => array(
                    'normalize.css',
                    'bootstrap.css',
                    'bootstrap-responsive.css',
                    'datepicker.css',
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

);