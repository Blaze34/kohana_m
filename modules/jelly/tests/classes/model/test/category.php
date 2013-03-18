<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Represents a category in the database.
 *
 * @package  Jelly
 */
class Model_Test_Category extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		// Set database to connect to
		$meta->db(Unittest_Jelly_Testcase::$database_connection);

		// Define fields
		$meta->fields(array(
			'id'         => Jelly::field('primary'),
			'name'       => Jelly::field('string'),
			'test_posts' => Jelly::field('manytomany'),
			'parent'     => Jelly::field('belongsto', array(
				'foreign' => 'test_category',
				'column'  => 'parent_id'
			)),
		));
	}

} // End Model_Test_Category