#### `Jelly_Field_Expression`

This field is a rather abstract type that allows you to pull a database expression back on SELECTs. Simply set your `column` to any `DB::expr()`.

For example, if you always wanted the field to return a concatenation of two columns in the database, you can do this:

	'field' => Jelly::field('expression', array(
		'column' => DB::expr("CONCAT(`first_name`, ' ', `last_name`)"),
	))

It is possible to cast the returned value using a Jelly field.
This should be defined in the `cast` property:

	'field' => Jelly::field('expression', array(
		'cast'   => 'integer', // This will cast the field using Jelly::field('integer')
		'column' => DB::expr("CONCAT(`first_name`, ' ', `last_name`)"),
	))

[!!] Keep in mind that aliasing breaks down in Database_Expressions.

[API documentation](../api/Jelly_Field_Expression)