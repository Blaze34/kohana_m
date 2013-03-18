<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Configs for Youtube API
 */
return array(
	'api_url' => 'http://gdata.youtube.com/feeds/api/',
		
	// API version
	'version' => '2',
		
    
    /**
     * Your API key
     * https://code.google.com/apis/youtube/dashboard/
     */
	'api_key' => '',

	// Data type - atom, rss, json and json-in-script
	'data_type' => 'jsonc',
		
	/**
	 * @param boolean
	 */
	'cached'  => true,
		
	/**
	 * @param array
	 */
	'order_columns' => array(
		'relevance', 'viewCount', 'updated', 'rating'
	),

); // END
