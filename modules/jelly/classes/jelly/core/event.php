<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Jelly Event acts as a manager for all events bound to a model
 *
 * The standard events are documented in the guide. Binding and
 * triggering custom events is entirely possible.
 *
 * @package    Jelly
 * @category   Events
 * @author     Jonathan Geiger
 * @copyright  (c) 2010-2011 Jonathan Geiger
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class Jelly_Core_Event {

	/**
	 * @var  array  The current model
	 */
	protected $_model = NULL;

	/**
	 * @var  array  Bound events
	 */
	protected $_events = array();

	/**
	 * Constructor.
	 *
	 * @param  string  $model
	 */
	public function __construct($model)
	{
		$this->_model = $model;
	}

	/**
	 * Binds an event.
	 *
	 * @param   string    $event
	 * @param   callback  $callback
	 * @return  Jelly_Event
	 */
	public function bind($event, $callback)
	{
		$this->_events[$event][] = $callback;
	}

	/**
	 * Triggers an event.
	 *
	 * @param   string  $event
	 * @param   mixed   $sender
	 * @param   mixed   $params...
	 * @return  mixed
	 */
	public function trigger($event, $sender, $params = array())
	{
		if ( ! empty($this->_events[$event]))
		{
			$data = new Jelly_Event_Data(array(
				'event'  => $event,
				'sender' => $sender,
				'args'   => $params,
			));

			// Create the params to be passed to the callback
			// Sender, Params...and Event as the last one
			array_unshift($params, $sender);
			array_push($params, $data);

			foreach ($this->_events[$event] as $callback)
			{
				call_user_func_array($callback, $params);

				if ($data->stop)
				{
					break;
				}
			}

			return $data->return;
		}

		return NULL;
	}

} // End Jelly_Core_Event