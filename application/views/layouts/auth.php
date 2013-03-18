<!DOCTYPE html>
<html>
<head>
	<?=View::factory('layouts/_head')->set(array('meta' => $meta, 'css' => $css, 'js' => $js))->render()?>
</head>
<body>
<div class="container">
	<?=View::factory('layouts/_alerts')->set(array('errors' => $errors, 'success' => $success))->render()?>
	<?=$content?>
</div>
<?=View::factory('layouts/profiletoolbar');?>
</body>
</html>