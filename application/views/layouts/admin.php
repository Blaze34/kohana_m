<!DOCTYPE html>
<html>
<head>
    <?=View::factory('layouts/_head')->set(array('meta' => $meta, 'css' => $css, 'js' => $js))->render()?>
</head>
<body>
<div id="wrap">
    <div class="container">
        <?=View::factory('layouts/_header')->set(array('errors' => $errors, 'success' => $success))->render()?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3">
                    <?=View::factory('admin/index/menu')->render()?>
                </div>
                <div class="span9">
                    <?=$content?>
                </div>
            </div>
        </div>

    </div><!-- /container -->
    <div id="push"></div>
</div>
<?=View::factory('layouts/_footer')->render()?>
<?=View::factory('layouts/profiletoolbar');?>
</body>
</html>