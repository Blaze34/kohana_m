<!DOCTYPE html>
<html>
    <head>
        <?=View::factory('layouts/_head')->set(array('meta' => $meta, 'css' => $css, 'js' => $js))->render()?>
    </head>
    <body>
		<div id="page">
            <?=$content?>
		</div>
</body>
</html>