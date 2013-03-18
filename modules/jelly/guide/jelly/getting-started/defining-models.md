# Defining Models

The first place to start with any ORM is defining your models. Jelly splits up
models into a few separate components that make the API more coherent and
extensible.

First, let's start with a sample model:

	class Model_Post extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			// An optional database group you want to use
			$meta->db('default');
			
			// The table the model is attached to
			// It defaults to the name of the model pluralized
			$meta->table('posts');

			// Optionally you can auto-load relationships every time you load the model
			$meta->load_with('author');
		
			// Fields defined by the model
			$meta->fields(array(
				'id'      => Jelly::field('primary'),
				'name'    => Jelly::field('string'),
				'body'    => Jelly::field('text'),
				'status'  => Jelly::field('enum', array(
					'choices' => array('draft', 'review', 'published')
				)),
				
				// Relationships to other models
				'author'   => Jelly::field('belongsto'),
				'comments' => Jelly::field('hasmany'),
				'tags'     => Jelly::field('manytomany'),
			));
		}
	}

As you can see all models must do a few things to be registered with Jelly:

 * They must extend `Jelly_Model`
 * They must define an `initialize()` method, which is passed a `Jelly_Meta` object
 * They must add properties to that `$meta` object to define the fields, table, keys and a number of other things. Most of these items are optional.

The `initialize()` method is only called once per execution for each model and the model's meta object is stored statically. If you need to find out anything about a particular model, you can use `Jelly::meta('model')`.

## Jelly Fields

Jelly defines [many field objects](field-types) that cover the most common types of columns used in database tables.

In Jelly, the field objects contain all the logic for retrieving, setting and saving database values.

Since all relationships are handled through relationship fields, it is possible to implement custom, complex relationship
logic in a model by [defining a custom field](extending-field).