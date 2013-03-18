#### `Jelly_Field_Boolean`

Represents a boolean. In the database, it is usually represented by a `tinyint`.

 * **`true`** — What to save `TRUE` as in the database. This defaults to 1, but you may want to have `TRUE` values saved as 'Yes', or 'TRUE'.
 * **`false`** - What to save `FALSE` as in the database.

[!!] An exception will be thrown if you try to set `convert_empty` to `TRUE` on this field.

[API documentation](../api/Jelly_Field_Boolean)