#### `Jelly_Field_Timestamp`

Represents a timestamp. This field always returns its value as a UNIX timestamp, however you can choose to save it as any type of value you'd like by setting the `format` property.

 * **`format`** — By default, this field is saved as a UNIX timestamp, however you can set this to any valid `date()` format and it will be converted to that format when saving.
 * **`auto_now_create`** — If TRUE, the value will save `now()` whenever INSERTing.
 * **`auto_now_update`** — If TRUE, the field will save `now()` whenever UPDATEing.

[API documentation](../api/Jelly_Field_Timestamp)