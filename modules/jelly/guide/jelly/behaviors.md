# Behaviors and Events

Jelly makes it possible to create behaviors that define actions which are executed on a specific event, for example before saving a model or after saving a model. But they are much more capable then this as **Banks** describes them:

> Behaviors allow you to add functionality to model _instances_ (as well as model builders) in such a way that multiple inheritance is achievable. For instance one model may have MPTT ordering AND be version controlled simply by declaring that it displays both behaviors. Another model may only support MPTT without convoluted inheritance trees or code duplication.
>
> The fact that a behavior can add enhancements to the model builder may blur the lines slightly but this is simple so that if you declare that your model behaves in a certain way, that can imply certain functionality both for instances of that model and lists of that model.
>
> For example, I may write several different models that all share some functionality such as maintaining a published / unpublished status. Rather than duplicate all the fields / code for handling this status, I may just create a behavior - called `Jelly_Behavior_Publishable` - which adds functions to the instance like `is_published()` or `publish_now()`, but could also add functions to the builder like `published(TRUE)`. So I can do things like `Jelly::query('post')->published(TRUE)` and not have to duplicate the publishing related functions in multiple models.

## Creating behaviors

By default behaviors should go under *APPATH/classes/jelly/behavior* and they must extend `Jelly_Behavior`.

An example behavior:

	<?php defined('SYSPATH') or die('No direct access allowed.');

	class Jelly_Behavior_Post extends Jelly_Behavior {

		public function model_before_save($params, $event_data)
		{
			// Do stuff
		}

	} // End Jelly_Behavior_Post

#### Events in behaviors

In the example above the `model_before_save($params, $event_data)` method is called just before the model is saved.
The event methods receive parameters and event data when triggered, which contents are different for each event.

#### Event data

Every event receives event data, which can be useful for a number of things. You can set the return value of the event
or decide if you want to execute further events in a certain situation.

The returned value might alter the result of an action, check out the following for an example.

	<?php defined('SYSPATH') or die('No direct access allowed.');

	class Jelly_Behavior_Post extends Jelly_Behavior {

		public function model_before_save($params, $event_data)
		{
			if ($param->loaded())
			{
				// Set the returned value of the event, in this case returning
				// FALSE this will make Jelly skip the saving of the model
				$event_data->return = FALSE;

				// Stop the execution of further events
				$event_data->stop = TRUE;
			}
		}

	} // End Jelly_Behavior_Post

#### Available default events

Jelly has some built in events, like the one mentioned above. Check out the complete list of [available events](behaviors/events).

#### Create custom events

You are free to create your own events, [read the guide](behaviors/custom-events) to get familiar with the event API.


## Loading behaviors in models

If a behavior is created with the same name as the model it gets automatically loaded. For example `Model_Post` loads the behavior `Jelly_Behavior_Post`.

Adding behaviors that have different naming is done in the `initialize()` method.

	<?php defined('SYSPATH') or die('No direct access allowed.');

	class Model_Post extends Jelly_Model
	{
		public static function initialize(Jelly_Meta $meta)
		{
			// Load behaviors
			$meta->behaviors(array(
				'foo' => Jelly::behavior('Foo'),
				'bar' => Jelly::behavior('Bar'),
			));

			// Fields defined by the model
			$meta->fields(array(
				// Define fields
			));
		}

	} // End Model_Post