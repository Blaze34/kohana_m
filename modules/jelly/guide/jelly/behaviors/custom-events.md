# Custom Events

You can create two types of custom events for behaviors:

- auto-discoverable event
- event that has to be binded manually

You can call these events wherever you want in your models or builders.

## Auto-discoverable events

To create events that are automatically discovered and binded to behaviors all you have to do is prefix your methods with one of the following:

- `model_`
- `builder_`
- `meta_`

An example behavior with a custom event:

	<?php defined('SYSPATH') or die('No direct access allowed.');

	class Jelly_Behavior_Post extends Jelly_Behavior {

		public function model_publish_post($params, $event_data)
		{
			// Do stuff
		}

	} // End Jelly_Behavior_Post

## Manually bindable events

You can create events with totally custom names, an example would be:

	<?php defined('SYSPATH') or die('No direct access allowed.');

	class Jelly_Behavior_Post extends Jelly_Behavior {

		public function my_custom_event($params, $event_data)
		{
			// Do stuff
		}

	} // End Jelly_Behavior_Post

These events have to be binded to behaviors manually by:

	$this->_meta->events()->bind($event, $callback);

- `$event`: the name of the event, for example: 'my.custom_event'. Note the prefix!
- `$callback`: the callback that has to be called for the specific event, for example this would call the `my_custom_event()` method in the **Post** behavior: `array(Jelly::behavior('Post'), 'my_custom_event')`

## Triggering the events

The custom events can be triggered in your models or builders like this:

	$this->_meta->events()->trigger($event, $sender, $params);

- `$event`: the name of the event, for example: 'model.publish_post'. Note the prefix!
- `$sender`: the sender of the trigger, you can set it to `$this` for example
- `$params`: custom parameters for the event