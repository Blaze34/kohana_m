<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'tmp_dir' => 'uploads/materials/',
	'thumb' => array(
		'default' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALEAAABfCAYAAACnZyY3AAAEt0lEQVR4Xu3YV0tkWxCG4TLnnBUDRkYRTGAAUf+5IogJFb0QlRl1REHMWYyHWof2mHoGzl3VeveNYffu7q++p5drm3J6evoqHEzA8ARSQGy4Pd56mACIgWB+AiA2XyEBQIwB8xMAsfkKCQBiDJifAIjNV0gAEGPA/ARAbL5CAoAYA+YnAGLzFRIAxBgwPwEQm6+QACDGgPkJgNh8hQQAMQbMTwDE5iskAIgxYH4CIDZfIQFAjAHzEwCx+QoJAGIMmJ8AiM1XSAAQY8D8BEBsvkICgBgD5icAYvMVEgDEGDA/ARCbr5AAIMaA+QmA2HyFBAAxBsxPAMTmKyQAiDFgfgIgNl8hAUCMAfMTALH5CgkAYgyYnwCIzVdIABBjwPwEQGy+QgKAGAPmJwBi8xUSAMRJDDw+Psr8/Lzk5ORIX19feNT29rb8/PnzyxUjIyNyeHiY9Fxubu4fpe3s7Mje3p68vLxIRUWFtLe3S3p6erhma2tLdnd3367X34+PjyP33QRA/A2Hi4sLWV9fl+vrayktLX1DfH5+LnpOj9fX14A6Ly9PBgYG5PLyMum51NTUpOgU/9ramjQ0NEhWVlZAW1NTI11dXeGahYUF0Q9UXV1d+Fmfq76+HsQgTm7g6elJJicnpbq6Wo6OjqSoqOgN8furfv36Jb9//5ahoSHJzs7+8ISfz+lKqjibm5sD1rm5OXl+fpbBwUFJrMITExOSlpYW0OqHR1db/aDoe1G4ukrrX4XOzs7wnjj+mwAr8ScNCufm5kby8/NlampKCgoKviC+v7+XmZkZaWlpkcbGxg/PkOzc0tKSnJ2dhZX95OREent7paysLHwQNjc3w8/6WrOzs/Lw8CCjo6MB7urqqpSUlITH6uN0VdbtS2K7AWYREP9BQTLEGxsbcnBwEKB9xpTsnMJMAFX4bW1t4ZUTUI+Pj8NKnJmZKXd3d+G5dXvx/kiA7+/vD7A5/p0AiP8H4unpaSkuLpbu7u4vVyc7p6u73ijqNuL9PltXfgWuXzMyMmRlZUWurq5kbGws/EXQLY1ubXQrkUCse3B9fQ4Q/9XAdyvx7e1t2Ep0dHR8ucFKdk5XW93r6gpbW1sbMLa2tkpTU1PYWiwvL4cbN71J1C2Dfv/jx4+wN9b9s6LX3+m+OiUlRYaHh8NXDhD/1cB3iBPoenp6pLy8/MNzJDunMBWurtyVlZWyuLgY/puhK6repCnO/f39sJ2oqqoKe239Xo/Ev+50r11YWBhwK3YObuww4GgC7IkdlRlrFBDH2ryj3CB2VGasUUAca/OOcoPYUZmxRgFxrM07yg1iR2XGGgXEsTbvKDeIHZUZaxQQx9q8o9wgdlRmrFFAHGvzjnKD2FGZsUYBcazNO8oNYkdlxhoFxLE27yg3iB2VGWsUEMfavKPcIHZUZqxRQBxr845yg9hRmbFGAXGszTvKDWJHZcYaBcSxNu8oN4gdlRlrFBDH2ryj3CB2VGasUUAca/OOcoPYUZmxRgFxrM07yg1iR2XGGgXEsTbvKDeIHZUZaxQQx9q8o9wgdlRmrFFAHGvzjnKD2FGZsUYBcazNO8oNYkdlxhoFxLE27yg3iB2VGWsUEMfavKPc/wDR9dMVQi0LLAAAAABJRU5ErkJggg==',
		'as' => 'jpg',
		'dir' => 'uploads/materials/thumb/',
		'split' => 1000,
		'hash' => 'sha1',
		'salt' => 'k84yflk46e',
		'width' => 177,
		'height' => 95,
		'quality' => 100,
	),

	'gif' => array(
		'as' => 'gif',
		'hash' => 'sha1',
		'salt' => 'k84yflk46e',
		'dir' => 'uploads/materials/gif/',
		'split' => 1000,
		'size' => '25M',
		'extensions' => array(
			'gif'
		),
		'mimes' => array(
			'image/gif'
		),
	)
);
