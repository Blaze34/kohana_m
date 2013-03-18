<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Handles json data.
 *
 * When set, the field attempts to json_decode the data into it's
 * actual PHP representation. When the model is saved, the value
 * is json_encoded back and saved as a string into the column.
 *
 * @package  Jelly
 */
abstract class Jelly_Core_Field_Json extends Jelly_Field
{
	/**
	 * @var  string  default value is a string, since we null is FALSE
	 */
	public $default = '';

	/**
	 * @var  boolean  do not allow null values by default
	 */
	public $allow_null = FALSE;
    
	/**
	 * Json_decodes data as soon as it comes in.
	 *
	 * Incoming data that isn't actually serialized will not be harmed.
	 *
	 * @param   mixed  $value
	 * @return  mixed
	 */

    public function set($value)
	{
		list($value, $return) = $this->_default($value);

		if ( ! $return)
		{
            // trying to convert from json
            try
            {
                $value = json_decode($value, TRUE);
            }
            catch (ErrorException $e)
            {
            }
		}

		return $value;
	}
    

	/**
	 * Saves the value as a json object
	 *
	 * @param   Jelly_Model  $model
	 * @param   mixed        $value
	 * @param   boolean      $loaded
	 * @return  null|string
	 */
	public function save($model, $value, $loaded)
	{
        if ($this->allow_null AND $value === NULL)
		{
			return NULL;
		}
        
        // converting to json
		return json_encode($value);
	}
}