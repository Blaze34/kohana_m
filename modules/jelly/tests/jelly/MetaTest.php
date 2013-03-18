<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tests Jelly_Meta
 *
 * @package Jelly
 * @group   jelly
 * @group   jelly.meta
 */
class Jelly_MetaTest extends Unittest_TestCase {

	/**
	 * Tests various properties on a meta object.
	 */
	public function test_properties()
	{	
		$fields = array(
			'id' => new Jelly_Field_Primary,
			'id2' => new Jelly_Field_Primary,
			'name' => new Jelly_Field_String,
		);
		
		$meta = new Jelly_Meta;
		$meta->db('foo')
		     ->table('foo')
		     ->builder('Jelly_Builder_Foo')
		     ->fields($fields)
		     ->fields(array(
		     	'_id' => 'id2',
		     ))
		     ->sorting(array('foo' => 'bar'))
		     ->primary_key('id2')
		     ->name_key('name')
		     ->foreign_key('meta_fk')
		     ->load_with(array('test_post'))
			 ->behaviors(array(new Jelly_Behavior_Test))
		     ->finalize('meta');
		
		// Ensure the simple properties are preserved
		$expected = array(
			'initialized' => TRUE,
			'db' => 'foo',
			'table' => 'foo',
			'model' => 'meta',
			'primary_key' => 'id2',
			'name_key'    => 'name',
			'foreign_key' => 'meta_fk',
			'builder'     => 'Jelly_Builder_Foo',
			'sorting'     => array('foo' => 'bar'),
			'load_with'   => array('test_post'),
		);
		
		foreach ($expected as $property => $value)
		{
			$this->assertSame($meta->$property(), $value);
		}
		
		// Ensure we can retrieve fields properly
		$this->assertSame($meta->field('_id'), $fields['id2']);
		$this->assertSame($meta->field('id2')->name, 'id2');
		
		// Ensure all fields match
		$this->assertSame($meta->fields(), $fields);
		
		// Ensure defaults are set properly
		$this->assertSame($meta->defaults(), array(
			'id' => NULL, 
			'id2' => NULL, 
			'name' => ''
		));

		foreach ($meta->behaviors() as $behavior)
		{
			// Ensure Behaviors return actual objects
			$this->assertTrue($behavior instanceof Jelly_Behavior);
		}
	}
}