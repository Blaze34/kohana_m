#### `Jelly_Field_Enum`

Represents an enumerated list. Keep in mind that this field accepts any value passed to it, and it is not until you `validate()` the model that you will know whether or not the value is valid or not.

If you `allow_null` on this field, `NULL` will be added to the choices array if it isn't currently in it. Similarly, if `NULL` is in the choices array `allow_null` will be set to `TRUE`.

 * **`choices`** — An array of valid choices.

[API documentation](../api/Jelly_Field_Enum)