<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Declares a field that can have individual records add()ed or remove()ed from it
 *
 * This interface does not require any methods to be declared, but rather
 * acts as a flag for the model so that it knows the field supports this feature.
 *
 * In general, relationships that are not 1:1 but are 1:many or many:many should
 * implement this interface. This means that in the field's set() method, it should
 * expect to handle a multitude of values, including:
 *
 * - A primary key
 * - Another Jelly model
 * - An iterable collection of primary keys or
 *   Jelly models, such as an array or Database_Result
 *
 * And in its save() method, it should expect an array of primary keys.
 *
 * @package    Jelly
 * @category   Fields/Interfaces
 * @author     Jonathan Geiger
 * @copyright  (c) 2010-2011 Jonathan Geiger
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
interface Jelly_Core_Field_Supports_AddRemove extends Jelly_Field_Supports_Save {}