#### `Jelly_Field_ManyToMany` (many:many)

This connects two models so that each can have many of each other.

For example, a blog post might have many tags, but a particular tag might
belong to many different blog posts.

This relationship requires a `through` table that connects the two models.

	// In Model_Post::initialize()
	'tags' => Jelly::field('manytomany', array(
		'foreign' => 'tag',
		'through' => 'posts_tags',
	)),

**Properties**

**`foreign`** — The model that this field has many of. You can also pass a field to use as the foreign model's primary key.

	// The default, using the above example
	'foreign' => 'tag.tag:primary_key',

**`through`** — The table or model to use as the connector table. You can also pass an array of fields to use for connecting the two primary keys. Unlike `foreign`, the model can actually point to a table, and does not need to point to an actual model.

	// The default, using the above example
	'through' => array(
		'model' => 'posts_tags',
		'fields' => array('post:foreign_key', 'tag:foreign_key'),
	),

**Using this relationship**

	$post = Jelly::query('post', 1)->select();

	// Access all tags
	foreach ($post->tags as $tag)
	{
		echo $tag->name;
	}

	// Delete all related tags
	$post->get('tags')->delete();

	// Change the tags
	$post->tags = Jelly::query('tag')->where('id', 'IN', $tags)->select();
	$post->save();

	// Remove the tags
	$post->tags = NULL;
	$post->save();

[!!] See `add()`, `remove()`, and `has()` [methods](../jelly/relationships#add-and-remove) for more examples.