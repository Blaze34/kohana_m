<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Handles json data.
 *
 * When set, the field attempts to json_decode the data into it's
 * actual PHP representation. When the model is saved, the value
 * is json_encoded back and saved as a string into the column.
 *
 * @package Jelly
 */
class Jelly_Field_Json extends Jelly_Core_Field_Json {

}