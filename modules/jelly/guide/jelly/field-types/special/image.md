#### `Jelly_Field_Image`

Represents an image upload. This behaves almost exactly the same as `Jelly_Field_File` except it allows to transform the original image and create unlimited number of different thumbnails.

To make this field required use the `Upload::not_empty` rule instead of the simple `not_empty`.

Here is an example where you resize the original image and create a thumbnail.


	Jelly::field('image', array(
		// where to save the original image
		'path'			  => 'upload/images/',
		// transformations for the original image, refer to the Image module on available methods
		'transformations' => array(
			'resize' => array(1600, 1600, Image::AUTO),  // width, height, master dimension
		),
		// desired quality of the saved image, default 100
		'quality'		  => 75,
		// define your thumbnails here, if saving the thumbnail to the original's directory don't forget to set a prefix
		'thumbnails'      => array (
			// 1st thumbnail
			array(
				// where to save the thumbnail
				'path'   => 'upload/images/thumbs/',
				// prefix for the thumbnail filename
				'prefix' => 'thumb_',
				// transformations for the thumbnail, refer to the Image module on available methods
				'transformations' => array(
					'resize' => array(500, 500, Image::AUTO),  // width, height, master dimension
					'crop'   => array(100, 100, NULL, NULL),   // width, height, offset_x, offset_y
				),
				// desired quality of the saved thumbnail, default 100
				'quality' => 50,
			),
			// 2nd thumbnail
			array(
				// ...
			),
		)
	));

[!!] The transformation steps will be performed in the order you specify them in the array.

 * **`path`** — This must point to a valid, writable directory to save the original image to.
 * **`transformations`** — Transformations for the image, refer to the Image module on available methods.
 * **`quality`** — desired quality of the saved image between 0 and 100, defaults to 100.
 * **`driver`** — image driver to use, default is `NULL` which will result in using [Image::$default_driver](../api/Image#property:default_driver)
 * **`delete_old_file`** — Whether or not to delete the old files when a new image is successfully uploaded. Defaults to `FALSE`.
 * **`delete_file`** — If this value is `TRUE` image and thumbnails are automatically deleted upon deletion. The default is `FALSE`.
 * **`types`** — Valid file extensions that the file may have. Defaults to allowing JPEGs, GIFs, and PNGs.

 [API documentation](../api/Jelly_Field_Image)