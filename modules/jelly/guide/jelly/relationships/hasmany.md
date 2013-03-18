#### `Jelly_Field_HasMany` (1:many)

This relationship is essentially the reverse of a `belongs_to` relationship. Here, a model has many of another model.

Following the `belongs_to` example: an author has many posts. In the database,
the `posts` table would have an `author_id` column that contains the primary
key of the author that owns the post.

	// In Model_Author::initialize()
	'posts' => Jelly::field('hasmany', array(
		'foreign' => 'post',
	)),

**Properties**

**`foreign`** — The model that this field has many of. You can also pass a field to use as the foreign model's foreign key.

	// The default, using the above example
	'foreign' => 'post.author:foreign_key',

**`default`** — This works slightly differently than other fields. Default is the value that will be set on the foreign model's column when a relationship is removed. This should almost always remain 0.

**`convert_empty`** — This defaults to `TRUE`, unlike most other fields. Empty values are converted to the value set for `empty_value`, which defaults to `0`.

**`empty_value`** — This is the default value that empty values are converted to. The default is `0`.

**`delete_dependent`** — If this value is `TRUE` dependent fields are automatically deleted upon deletion. The default is `FALSE`.

**Using this relationship**

	$author = Jelly::query('author', 1)->select();

	// Access all posts
	foreach ($author->posts as $post)
	{
		echo $post->name;
	}

	// Retrieve only published posts
	$posts = $author->get('posts')->where('status', '=', 'published')->select();

	// Change all posts
	$author->posts = array($post1, $post2, $post3);

	// Remove the relationship
	$author->posts = NULL;
	$author->save();

**Retrieving hasmany-hasmany relationships**

For example if an author has many posts that have many comments we can retrieve all the comments that were sent to the author's posts.

The recommended way of doing this is extending the query builder and creating a method to retrieve the comments.

	<?php defined('SYSPATH') or die('No direct script access.');

	class Model_Builder_Comment extends Jelly_Builder {

		public function get_authors_comments($author_id)
		{
			return $this->with('post:author')->where(':post:author.id', '=', $author_id);
		}

	}

From now on you can use this method this way:

	Jelly::query('comment')->get_authors_comments(1)->select();


[!!] See `add()`, `remove()`, and `has()` [methods](../jelly/relationships#add-and-remove) for more examples.