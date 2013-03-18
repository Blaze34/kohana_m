# Built-in Events

The following methods can be used to do actions on specific events.

## Events for models

#### Validating

[!!] These methods receive the **model object** and the **validation object** in their params.

[!!] The events' return value has no effect on the workings of Jelly.

- `model_before_validate($params, $event_data)`
- `model_after_validate($params, $event_data)`

#### Saving

[!!] These methods receive the **model object** in their params.

[!!] If `model_before_save()` event's return value is `FALSE`, then saving is skipped.

- `model_before_save($params, $event_data)`
- `model_after_save($params, $event_data)`

#### Deleting

[!!] If `model_before_delete()` event's return value isn't `NULL`, then deleting is skipped, but `model_after_delete()` is still run.

- `model_before_delete($params, $event_data)`
- `model_after_delete($params, $event_data)`

***

## Events for builders

[!!] These methods receive the **builder object** in their params.

#### Selecting

[!!] The events' return value has no effect on the workings of Jelly.

- `builder_before_select($params, $event_data)`
- `builder_after_select($params, $event_data)`

#### Inserting

[!!] The events' return value has no effect on the workings of Jelly.

- `builder_before_insert($params, $event_data)`
- `builder_after_insert($params, $event_data)`

#### Updating

[!!] The events' return value has no effect on the workings of Jelly.

- `builder_before_update($params, $event_data)`
- `builder_after_update($params, $event_data)`

#### Deleting

[!!] If `builder_before_delete()` event's return value isn't `NULL`, then deleting is skipped, but `builder_after_delete()` is still run.

- `builder_before_delete($params, $event_data)`
- `builder_after_delete($params, $event_data)`

***

## Events for meta

[!!] These methods receive the **meta object** in their params.

[!!] The events' return value has no effect on the workings of Jelly.

- `meta_before_finalize($params, $event_data)`
- `meta_after_finalize($params, $event_data)`