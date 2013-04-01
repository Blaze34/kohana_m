<!DOCTYPE html>
<html>
<head>
<?=View::factory('layouts/_head')->set(array('meta' => $meta, 'css' => $css, 'js' => $js))->render()?>
</head>
<body>
<div id="wrap">
    <div class="container">
        <?=View::factory('layouts/_header')->render()?>

        <?=View::factory('layouts/top_form')->render()?>

        <?=Request::factory(Route::url('default', array('controller' => 'category', 'action' => 'slider')))->execute()?>

        <?=View::factory('layouts/_alerts')->set(array('errors' => $errors, 'success' => $success))->render()?>
	    <div class="container-fluid">
            <div class="row-fluid">
                <?=$content?>
            </div>
        </div>    
    </div><!-- /container -->
    <div id="push"></div>
</div>
<?=View::factory('layouts/_footer')->render()?>
<?=View::factory('layouts/profiletoolbar');?>
</body>
</html>
