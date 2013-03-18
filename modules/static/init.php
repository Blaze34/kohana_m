<?php
Route::set('static_view', '<alias>.html', array('alias' => '[A-Z,a-z,0-9,_,-,/]+'))
    ->defaults(array(
        'controller' => 'static',
		'action'	 => 'view',
    ));
Route::set('static', 'static/<action>(/<id>)(/<alias>)', array('id' => '[0-9]+', 'action' => '[a-z]+', 'alias' => '[A-Z,a-z,0-9,_,-,/]+'))
    ->defaults(array(
        'controller' => 'static',
		'action'	 => 'index',
    ));