<?php defined('SYSPATH') or die('No direct access allowed.');
return array
(

	// 86400 = 1 day caching.
	// 31536000 = 1 year caching.
	// You can always clear cache manually from the admin area.
	
	'memcache' => array(
		'driver'             => 'memcache',
		'default_expire'     => 86400,
		'compression'        => FALSE,              // Use Zlib compression (can cause issues with integers)
		'servers'            => array(
			array(
				'host'             => 'localhost',  // Memcache Server
				'port'             => 11211,        // Memcache port number
				'persistent'       => FALSE,        // Persistent connection
				'weight'           => 1,
				'timeout'          => 1,
				'retry_interval'   => 15,
				'status'           => TRUE,
			),
		),
		'instant_death'      => TRUE,               // Take server offline immediately on first fail (no retry)
	),
	'memcachetag' => array(
		'driver'             => 'memcachetag',
		'default_expire'     => 86400,
		'compression'        => FALSE,              // Use Zlib compression (can cause issues with integers)
		'servers'            => array(
			array(
				'host'             => 'localhost',  // Memcache Server
				'port'             => 11211,        // Memcache port number
				'persistent'       => FALSE,        // Persistent connection
				'weight'           => 1,
				'timeout'          => 1,
				'retry_interval'   => 15,
				'status'           => TRUE,
			),
		),
		'instant_death'      => TRUE,
	),
	'apc'      => array(
		'driver'             => 'apc',
		'default_expire'     => 86400,
	),
	'wincache' => array(
		'driver'             => 'wincache',
		'default_expire'     => 86400,
	),
	'sqlite'   => array(
		'driver'             => 'sqlite',
		'default_expire'     => 86400,
		'database'           => APPPATH.'cache/kohana-cache.sql3',
		'schema'             => 'CREATE TABLE caches(id VARCHAR(127) PRIMARY KEY, tags VARCHAR(255), expiration INTEGER, cache TEXT)',
	),
	'eaccelerator'           => array(
		'driver'             => 'eaccelerator',
	),
	'xcache'   => array(
		'driver'             => 'xcache',
		'default_expire'     => 86400,
	),
	'file'    => array(
		'driver'             => 'file',
		'cache_dir'          => APPPATH.'cache',
		'default_expire'     => 86400,
		'ignore_on_delete'   => array(
			'.gitignore',
			'.git',
			'.svn'
		)
	)
);