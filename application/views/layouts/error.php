<!DOCTYPE html>
<html>
<head>
<?=View::factory('layouts/_head')->set(array('meta' => $meta, 'css' => $css, 'js' => $js))->render()?>
</head>
<body>
<div class="container">
	<?=$content?>
</div>
<?=View::factory('layouts/profiletoolbar');?>
</body>
</html>