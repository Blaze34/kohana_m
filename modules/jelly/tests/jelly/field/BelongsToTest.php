<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tests BelongsTo fields.
 *
 * @package Jelly
 * @group   jelly
 * @group   jelly.field
 * @group   jelly.field.belongs_to
 */
class Jelly_Field_BelongsToTest extends Unittest_Jelly_TestCase {

	/**
	 * Provides test data for test_get()
	 *
	 * @return  array
	 */
	public function provider_get()
	{
		return array(
			// Get existing author
			array(Jelly::factory('test_post', 1)->get('test_author'), TRUE),
			// Get existing author
			array(Jelly::factory('test_post', 2)->get('test_author'), TRUE),
			// Get existing author with invalid name
			array(Jelly::factory('test_post', 2)->get('test_author')->where('name', 'IS', NULL), FALSE),
			// Get non-existing author
			array(Jelly::factory('test_post', 555)->get('test_author'), FALSE),
			// Get author without specifying a post
			array(Jelly::factory('test_post')->get('test_author'), FALSE),
		);
	}

	/**
	 * Tests for Jelly_Field_BelongsTo::get()
	 *
	 * @dataProvider  provider_get
	 * @param         Jelly         $builder
	 * @param         bool          $loaded
	 * @return        void
	 */
	public function test_get($builder, $loaded)
	{
		$this->assertTrue($builder instanceof Jelly_Builder);

		// Load the model
		$model = $builder->select();

		// Ensure it's loaded if it should be
		$this->assertSame($loaded, $model->loaded());
	}

} // End Jelly_Field_BelongsToTest