#### `Jelly_Field_Password`

Represents an password. This automatically sets a validation callback that hashes the password after it's validated. That password is hashed only when it has changed.

 * **`hash_with`** — A valid PHP callback to use for hashing the password. Defaults to `sha1`.

[API documentation](../api/Jelly_Field_Password)