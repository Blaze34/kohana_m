<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Represents a specific role in the database.
 *
 * @package  Jelly
 */
class Model_Test_Role extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
	{
		// Set database to connect to
		$meta->db(Unittest_Jelly_Testcase::$database_connection);

		// Define fields
		$meta->fields(array(
			'id'   => Jelly::field('primary'),
			'name' => Jelly::field('string'),
		));
	}

} // End Model_Test_Role