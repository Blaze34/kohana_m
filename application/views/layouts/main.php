<!DOCTYPE html>
<html>
<head>
<?=View::factory('layouts/_head')->set(array('meta' => $meta, 'css' => $css, 'js' => $js))->render()?>
</head>
<body>
<div id="wrap">
    <div class="container">
        <?=View::factory('layouts/_alerts')->set(array('errors' => $errors, 'success' => $success))->render()?>
        <?=View::factory('layouts/_header')->render()?>
        <?=$content?>
    </div><!-- /container -->
    <div id="push"></div>
</div>
<?=View::factory('layouts/_footer')->render()?>
<?=View::factory('layouts/profiletoolbar');?>
</body>
</html>