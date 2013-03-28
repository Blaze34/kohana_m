<?$controller = Request::initial()->controller();?>

<ul class="nav nav-pills nav-stacked">
    <li class="<?=($controller == 'user') ? 'active' : ''?>"><a href="<?=Route::url('user', array('action' => 'index'))?>" ><?=__('adm.users')?></a ></li>
    <li class="<?=($controller == 'static') ? 'active' : ''?>"><a href="<?=Route::url('static')?>" ><?=__('adm.statics')?></a ></li>
    <li class="<?=($controller == 'category') ? 'active' : ''?>"><a href="<?=Route::url('default', array('controller' => 'category'))?>" ><?=__('adm.category')?></a ></li>
    <li class="<?=($controller == 'menu') ? 'active' : ''?>"><a href="<?=Route::url('default', array('controller' => 'menu'))?>" ><?=__('adm.menu')?></a ></li>
    <li class="<?=($controller == 'holder') ? 'active' : ''?>"><a href="<?=Route::url('default', array('controller' => 'holder'))?>" ><?=__('adm.holder')?></a ></li>
</ul>
