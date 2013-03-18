<?php
Route::set('tags', 'tags(/<resource>)(/<name>)', array('resource' => 'question|project|vacancy|article'))
    ->defaults(array(
        'controller' => 'tag',
    ));
