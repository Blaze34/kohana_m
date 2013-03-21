<?php defined('SYSPATH') or die('No direct script access.');

return array(

    'default' => array(
		'current_page'   => array('source' => 'query_string', 'key' => 'p'), // source: "query_string" or "route"
		'items_per_page' => 10,
		'view'           => 'pagination/twitter_bootstrap',
		'auto_hide'      => TRUE,
	),

    'list' => array(
		'current_page'   => array('source' => 'query_string', 'key' => 'p'), // source: "query_string" or "route"
		'items_per_page' => 15,
		'view'           => 'pagination/twitter_bootstrap',
		'auto_hide'      => TRUE,
	),

    'comments' => array(
		'current_page'   => array('source' => 'query_string', 'key' => 'p'), // source: "query_string" or "route"
		'items_per_page' => 10,
		'view'           => 'pagination/twitter_bootstrap',
		'auto_hide'      => TRUE,
	),
);