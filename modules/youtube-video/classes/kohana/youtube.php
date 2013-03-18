<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Youtube API module for Kohana
 * @author wwebfor
 * @url https://github.com/wwebfor/youtube-video
 */
class Kohana_Youtube
{
	/**
	 * @var array configs
	 */
	protected $configs = NULL;
	
	/**
	 * @var string API URL
	 */
	protected $api_url = NULL;
	
	/**
	 * @var string
	 */
	protected $query_url = '';
		
	/**
	 * @var object cached result
	 */
	protected $video = NULL;
	
	/**
	 * @var string
	 */
	protected $type = 'videos';
	
	/**
	 * @param string $type (videos|users)
	 */
	public static function factory($type = 'videos')
	{
		return new Kohana_Youtube($type);
	}
	
	public function __construct($type)
	{
		if($this->configs == NULL)
			$this->configs = Kohana::$config->load('youtube');

		$this->api_url = Arr::get($this->configs, 'api_url') . $type;
		$this->type = $type;
	}
	
	/**
     * Get results
	 */
	public function find_all()
	{			
		$this->build_url();
		$result = Request::factory($this->api_url)->execute();
		$this->video = json_decode($result);
		
		if( !isset($this->video->data))
			return NULL;
		
		return $this->video->data->items;
	}
	
	/**
     * Get video by id
	 */
	public function find($id)
	{
		$this->api_url .= '/' . $id;
		$this->build_url();
		
		$result = Request::factory($this->api_url)->execute();
		$video = json_decode($result);
		
		if( !isset($video->data))
			return NULL;
		
		return $video->data;
	}
	
	/**
     * Result counting
	 * @throws Kohana_Exception
	 */
	public function count_all()
	{
		if( $this->video == NULL)
			throw new Kohana_Exception('Model is not loaded');
		
		return $this->video->data->totalItems;
	}
	
	/**
     * Get video by user
	 * @param string $username
	 * @throws Kohana_Exception
	 */
	public function uploads($username)
	{
		if(strstr($this->api_url, '?') or $this->type != 'users')
			throw new Kohana_Exception('Wrong request!');
		
		$this->api_url .= '/' . $username . '/uploads';
		return $this;
	}
	
	/**
     * Get user playlists
	 * @param string $username
	 */
	public function playlist($username)
	{
		if(strstr($this->api_url, '?') or $this->type != 'users')
			throw new Kohana_Exception('Wrong request!');
		
		$this->api_url .= '/' . $username . '/playlists';
		return $this;
	}
	
	/**
     * Advanced search
	 * @param string $columnmabe (q|author|format|time)
	 * @param string $value 
	 */
	public function where($column = 'q', $value)
	{
		$value = stripslashes($value);
		
		// sanitizing
		$column = strtolower($column);
		$value  = urlencode($value);		
		$this->query_url .= $column . '=' . $value;

		return $this;
	}
	
	/**
     * and_where
	 * @param string $value
	 * @param string $column mabe (vq|author|format|time)
	 */
	public function and_where($column, $value)
	{
		return '&' . $this->where($column, $value);
	}
	
	/**
     * Sets for order_by query
	 * @param string $column
	 */
	public function order_by($column)
	{
		if( !in_array($column, Arr::get($this->configs, 'order_columns')))
			throw new Kohana_Exception("Its not supported order column");
		
		$this->query_url .= '&orderby=' . $column;
		return $this;
	}
	
	/**
     * Limits for videos
	 * @param int $i
	 */
	public function limit($i)
	{
		$i = intval($i);
		$this->query_url .= '&max-results=' . $i;
		return $this;
	}
	
	/**
     * Offset index for pagination
	 * @param int $offset
	 */
	public function offset($o)
	{
		$o = intval($o);
		$this->query_url .= '&start-index=' . $o;
		return $this;
	}
	
	/**
	 * API url building
	 */
	private function build_url()
	{
		$this->api_url .= '?' . $this->query_url;
		$this->api_url .= '&alt=jsonc';
		$this->api_url .= '&v=' . $this->configs['version'];
		$this->api_url .= '&key=' . $this->configs['api_key'];
	}
	
}// END
