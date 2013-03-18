#### `Jelly_Field_File`

Represents a file upload. Pass a valid file upload to this and it will be saved automatically in the location you specify.

In the database, the filename is saved, which you can use in your application logic.

To make this field required use the `Upload::not_empty` rule instead of the simple `not_empty`.

You must be careful not to pass `NULL` or some other value to this field if you do not want the current filename to be overwritten.

 * **`path`** — This must point to a valid, writable directory to save the file to.
 * **`delete_file`** — If this value is `TRUE` file is automatically deleted upon deletion. The default is `FALSE`.
 * **`delete_old_file`** — Whether or not to delete the old file when a new one is successfully uploaded. Defaults to `FALSE`.
 * **`types`** — Valid file extensions that the file may have.

[API documentation](../api/Jelly_Field_File)