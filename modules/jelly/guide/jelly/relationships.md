# Jelly Relationships

Jelly supports standard 1:1, 1:many and many:many relationships through special fields.

### Understanding the different relationships

The most common relationship types and the fields that represent them have been outlined in this menu, along with a
simple examples. Choose the relationship from the left menu.

[!!] In the examples the properties (such as `foreign` and `through` ) specified on the field are entirely optional but have been show for clarity.

### A general note on getting and setting relationships

#### Getting

You may have noticed in the examples that sometimes we use the object property syntax (`$model->field`) for retrieving a relationship and other times we use `$model->get('field')`.

The difference is that the object property syntax returns the relationship already `select()`ed, whereas `get()` returns a query builder that you can work with:

	// Here, a Jelly_Collection of models is returned
	$author->posts;
	
	// Here, a Jelly_Builder is returned
	$author->get('posts');
	
With `get()` you can add extra clauses to the query before you `select()` it, or you could actually perform a `delete()` or `update()` on the entire lot, if needed.

________________

#### Setting

Relationships are very flexible in the types of data you can pass to it. For `n:1` relationships, you can pass the following:

 * **A primary key**: e.g. `$post->author = 1;`
 * **A loaded() model**: e.g. `$post->author = Jelly::query('author', 1)->select();`
	
For `n:many` relationships, you can pass the following:

 * **An array of primary keys**: e.g. `$author->posts = array(1, 3, 5);`
 * **An array of models**: e.g. `$author->posts = array($model1, $model2, $model3);`
 * **A query result**: e.g. `$author->posts = Jelly::query('post')->select();`

### `add()` and `remove()`

These two methods offer fine-grained control over `n:many` relationships. You can use them to add or remove individual models from a relationship.

	// Assume this author has posts 1, 5, and 7
	$author = Jelly::query('author', 1)->select();
	
	// Remove post 1
	$author->remove('posts', 1);
	
	// Remove post 5
	$author->remove('posts', Jelly::query('post', 5)->select());
	
	// Make the changes permanent
	$author->save();
	
	// Add back post 1 and 5
	$author->add('posts', Jelly::query('post')->where('id', 'IN', array(1, 5))->select());

As you can see, `add()` and `remove()` support passing all of the different types of data outlined above.

### `has()`

Has is useful to determine if a model has a relationship to a particular model or set of models. Like `add()` and `remove()`, this method only works on `n:many` relationships.

	// Assume this author has posts 1, 5, and 7
	$author = Jelly::query('author', 1)->select();

	// Returns TRUE
	$author->has('posts', 1);

	// Returns FALSE, since the author doesn't have post 8
	$author->has('posts', array(1, 5, 7, 8));
	
	// Returns TRUE
	$author->has('posts', Jelly::query('post', 1)->select());

	// Returns TRUE
	$author->has('posts', Jelly::query('post')->where('id', 'IN', array(1, 5))->select());
	
Once again, `has()` supports passing all of the different types of data outlined above.