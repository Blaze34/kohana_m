<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Handles has many relationships
 *
 * @package    Jelly
 * @category   Fields
 * @author     Jonathan Geiger
 * @copyright  (c) 2010-2011 Jonathan Geiger
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class Jelly_Core_Field_HasMany extends Jelly_Field implements Jelly_Field_Supports_AddRemove, Jelly_Field_Supports_Has {

	/**
	 * @var  boolean  false, since this field does not map directly to a column
	 */
	public $in_db = FALSE;

	/**
	 * @var  boolean  null values are not allowed since an empty array expresses no relationships
	 */
	public $allow_null = FALSE;

	/**
	 * @var  array  default is an empty array
	 */
	public $default = array();

	/**
	 * @var  array  the default to set on foreign fields when removing the relationship
	 */
	public $foreign_default = 0;

	/**
	 * @var  boolean  empty values are converted by default
	 */
	public $convert_empty = TRUE;

	/**
	 * @var  int  empty values are converted to array(), not NULL
	 */
	public $empty_value = array();

	/**
	 * @var  string  a string pointing to the foreign model and (optionally, a
	 *               field, column, or meta-alias).
	 */
	public $foreign = '';

	/**
	 * @var  boolean  dependent fields are automatically deleted if set to TRUE.
	 */
	public $delete_dependent = FALSE;

	/**
	 * Determines the actual foreign model and field that the
	 * relationship is tied to.
	 *
	 * @param   string  $model
	 * @param   string  $column
	 * @return  void
	 */
	public function initialize($model, $column)
	{
		parent::initialize($model, $column);

		// Empty? The model defaults to the the singularized name
		// of this field, and the field defaults to this field's model's foreign key
		if (empty($this->foreign))
		{
			$this->foreign = inflector::singular($this->name).'.'.$model.':foreign_key';
		}
		// We have a model? Default the field to this field's model's foreign key
		elseif (FALSE === strpos($this->foreign, '.'))
		{
			$this->foreign = $this->foreign.'.'.$model.':foreign_key';
		}

		// Create an array fo easier access to the separate parts
		$this->foreign = array_combine(array('model', 'field'), explode('.', $this->foreign));
	}

	/**
	 * Converts a Database_Result, Jelly, array of ids, or an id to an array of ids.
	 *
	 * @param   mixed  $value
	 * @return  array
	 */
	public function set($value)
	{
		list($value, $return) = $this->_default($value);

		if ( ! $return)
		{
			$value = $this->_ids($value);
		}

		return $value;
	}

	/**
	 * Returns a Jelly_Builder that can then be selected, updated, or deleted.
	 *
	 * @param   Jelly_Model    $model
	 * @param   mixed          $value
	 * @return  Jelly_Builder
	 */
	public function get($model, $value)
	{
		if ($model->changed($this->name))
		{
			return Jelly::query($this->foreign['model'])
			            ->where($this->foreign['model'].'.'.':primary_key', 'IN', $value);
		}
		else
		{
			return Jelly::query($this->foreign['model'])
			            ->where($this->foreign['model'].'.'.$this->foreign['field'], '=', $model->id());
		}
	}

	/**
	 * Implementation of Jelly_Field_Supports_Save.
	 *
	 * @param   Jelly_Model  $model
	 * @param   mixed        $value
	 * @param   boolean      $loaded
	 * @return  void
	 */
	public function save($model, $value, $loaded)
	{
		// Don't do anything on INSERTs when there is nothing in the value
		if ( ! $loaded and empty($value)) return;

		// Empty relations to the default value
		Jelly::query($this->foreign['model'])
		     ->where($this->foreign['model'].'.'.$this->foreign['field'], '=', $model->id())
		     ->set(array($this->foreign['field'] => $this->foreign_default))
		     ->update();

		// Set the new relations
		if ( ! empty($value) AND is_array($value))
		{
			// Update the ones in our list
			Jelly::query($this->foreign['model'])
			     ->where($this->foreign['model'].'.'.':primary_key', 'IN', $value)
			     ->set(array($this->foreign['field'] => $model->id()))
			     ->update();
		}
	}

	/**
	 * Deletes the dependent fields if automatic relationship deletion
	 * is enabled.
	 *
	 * @param   Jelly_Model  $model
	 * @param   mixed        $key
	 * @return  void
	 */
	public function delete($model, $key)
	{
		// Set the field name
		$field = $this->name;

		// Set dependents
		$dependents = $model->$field;

		if ($this->delete_dependent AND $dependents->count() > 0)
		{
			foreach ($dependents as $dependent)
			{
				// Delete the field
				$dependent->delete();
			}
		}

		return;
	}

	/**
	 * Implementation of Jelly_Field_Supports_Has.
	 *
	 * @param   Jelly_Model  $model
	 * @param   mixed        $models
	 * @return  boolean
	 */
	public function has($model, $models)
	{
		return (bool) Jelly::query($this->foreign['model'])
		                   ->where($this->foreign['model'].'.'.$this->foreign['field'], '=', $model->id())
		                   ->where($this->foreign['model'].'.'.':primary_key', 'IN', $this->_ids($models))
		                   ->count();
	}

} // End Jelly_Core_Field_HasMany