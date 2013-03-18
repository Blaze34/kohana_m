# Jelly Field Types

Jelly comes with many common field types defined as objects with suitable
logic for retrieving and formatting them for the database.

### Field properties

Each field allows you to pass an array to its constructor to easily configure it. All parameters are optional.

#### Global properties

The following properties apply to nearly all fields.

**`in_db`** — Whether or not the field represents an actual column in the table.

**`default`** — A default value for the field.

**`allow_null`** — Whether or not `NULL` values can be set on the field. This defaults to `TRUE` for most fields, except for the string-based fields and relationship fields, in which case it defaults to `FALSE`.

 * If this is `FALSE`, most fields will convert the `NULL` to the field's `default` value. 
 * If this is `TRUE` the field's `default` value will be changed to `NULL` (unless you set the default value yourself).

**`convert_empty`** — If set to `TRUE` any `empty()` values passed to the field will be converted to whatever is set for `empty_value`. This also sets `allow_null` to `TRUE` if `empty_value` is `NULL`.

**`empty_value`** — This is the value that `empty()` values are converted to if `convert_empty` is `TRUE`. The default for this is `NULL`.

______________

#### in_db field properties

The following properties mostly apply to fields that actually represent a column in the table.

**`column`** — The name of the database column to use for this field. If this isn't given, the field name will be used.

**`primary`** — Whether or not the field is a primary key. The only field that
has this set to `TRUE` is `Jelly_Field_Primary`. A model can only have one primary field.

______________

#### Validation properties

The following properties are available to all of the field types and mostly relate to validation. There is a more in-depth discussion of these properties on [the validation documentation](validation).

**`unique`** — A shortcut property for validating that the field's data is unique in the database.

**`label`** — The label to use for the field when validating.

**`filters`** — Filters to apply to data before validating it.

**`rules`** — Rules to use to validate the data with.