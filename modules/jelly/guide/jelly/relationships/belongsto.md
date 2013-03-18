#### `Jelly_Field_BelongsTo` (1:1)

This field allows one model to belong to, or be *owned by*, another model.

For example, a post belongs to one author. In the database, the `posts` table would have an `author_id` column that contains the primary key of the author it belongs to.

	// In Model_Post::initialize()
	'author' => Jelly::field('belongsto', array(
		'column' => 'author_id',
		'foreign' => 'author',
	)),

**Properties**

**`column`** — This specifies the name of the column that the field represents. `BelongsTo` is different from other relationships in that
it actually represents a column in the database. Generally, this property is going to be equal to the foreign key of the model it belongs to.

	// The default, using the above example
	'column' => 'author_id'

**`foreign`** — The model that this field belongs to. You can also pass a field to use as the foreign model's primary key.

	// The default, using the above example
	'foreign' => 'author.post:primary_key',

**`convert_empty`** — This defaults to TRUE, unlike most other fields. Empty values are converted to the value set for `empty_value`, which defaults to `0`.

**`empty_value`** — This is the value that empty values are converted to. The default is `0`.

**Using this relationship**

	// Build query
	$post = Jelly::query('post', 1);

	// Multiple 1:1 relationships can be joined upon querying using the 'with()' method,
	// in this case post belongs to author and author belongs to role
	$post->with('author:role');

	// Select the post only if it was written by admin (notice the ':' before the joined models)
	$post->where(':author:role.type', '=', 'admin')->select();

	// Access the author's name
	echo $post->author->name;

	// Change the author
	$post->author = Jelly::query('author', 1)->select();
	$post->save();

	// Remove the relationship
	$post->author = NULL;
	$post->save();