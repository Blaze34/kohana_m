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
abstract class Jelly_Core_Field_Wsize extends Jelly_Field
{
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
                if($value)
                {
                    $sizes = explode("|", $value);
                    if(is_array($sizes) AND ! empty($sizes))
                    {
                        $value = array();
                        for ($j=0; $j<count($sizes); $j++) {
                            $sizes_ = explode("#", $sizes[$j]);
                            if (count($sizes_) >= 2 ) {
                                $value[] = array(
                                    '0' => $sizes_[0],
                                    '1' => $sizes_[1]
                                );
                            } else {
                                $value[] = array(
                                    '0' => $sizes_[0]
                                );
                            }
                        }
                    }
                    return $value;
                }
            }
            catch (ErrorException $e)
            {
            }
		}

		return FALSE;
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
		return @Utils::json_encode($value);
	}
}