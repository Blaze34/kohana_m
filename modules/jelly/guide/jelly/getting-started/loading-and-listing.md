# Finding Records

Each model has a `Jelly_Builder` attached to it that is used for all query
operations. Models can choose to use the stock `Jelly_Builder` or to [extend Jelly_Builder](extending-builder) to add custom builder methods to their models.

### Finding records

Jelly has methods which allow you to grab a single record by key or a
collection of records matching conditions. The interface is very similar to
Kohana's Database Query Builder.

	// Find all posts. A Jelly_Collection of Model_Post's is returned.
	$posts = Jelly::query('post')->select();
	
	// Iterate over our posts to do stuff with them
	foreach($posts as $post)
	{
		if ($post->loaded())
		{
			echo "Post #{$post->id} is loaded";
		}
	}
	
	// Find the post with a unique_key of 1.
	$post = Jelly::query('post', 1)->select();
	
	// We don't have to iterate since a model is returned directly
	if ($post->loaded())
	{
		echo "Post #{$post->id} is loaded";
	}

To execute the query you end your query building with the `select()` method,
which returns a `Jelly_Collection`. A `Jelly_Collection` contains a collection
of records that, when iterated over returns individual models for you to work
with.

[!!] **Note**: Whenever you `limit()` a query to 1, `select()` returns the model instance directly, instead of returning a `Jelly_Collection`

### Conditions

Rather than defining conditions using SQL fragments we chain methods named similarly to SQL. This is where Kohana's Database Query Builder will seem very familiar.

	// Find all published posts, ordered by publish date
	$posts = Jelly::query('post')
	              ->where('status', '=', 'published')
	              ->order_by('publish_date', 'ASC')
	              ->select();

### Counting Records

At any time during a query builder chain, you can call the `count()` method to
find out how many records will be returned.

	$total_posts = Jelly::query('post')->where('published', '=', 1)->count();

### Returning results as an array

You can get the database results in an array using the `as_array()` method.

	// Load all posts
	$posts = Jelly::query('post')->select();

	// Return the data as an array for the id, name, and body fields
	$data = $posts->as_array(array('id', 'name', 'body'));

	// Return only the names in an array
	$data = $posts->as_array(array(NULL, 'name'));

### Returning `Jelly_Collection` regardless to the limit

You might want to return `Jelly_Collection` even if the limit is set to 0. This might be the case when you are iterating
through the results in a foreach loop even if there's only one result. In this case use can use the `select_all()` method
which will always return `Jelly_Collection`.

	// Get post limit from url
	$limit = (int) $this->request->query('limit');

	// Get all posts
	$posts =  Jelly::query('post')->limit($limit)->select_all();

	// Show all post
	foreach ($posts as $post)
	{
		echo $post->text;
	}

### Selecting only specified columns

You can select only specified columns in your queries with the `select_columns()` method.

	// Select one at a time
	$query->select_column('id')->select_column('name')->select();

	// Select a column and alias it (only possible with columns defined individually)
	$query->select_column('name', 'name_alias')->select();

	// Or many at a time
	$query->select_column(array('id', 'name', 'body'))->select();

### Database expressions

You can use database expressions just like in Kohana's [Database](../database/query/builder#database-expressions) module, with the same precautions.
This means ** a database expression is taken as direct input and no escaping is performed**.

Database expressions can be used in the following form:

	// Selecting a column and transforming it to uppercase while aliasing it to 'name_in_uppercase'
	Jelly::query('author')->select_column(DB::expr('UPPER(`name`)'), 'name_in_uppercase')->select();

	// Using database expression in a where statement
	Jelly::query('author')->where(DB::expr("BINARY `hash`"), '=', $hash)->select();