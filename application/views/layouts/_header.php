<?$user = A2::instance()->get_user();?>
<div class="page-header">
    <div class="site_logo pull-left">
        <a href="/"><img src="/web/img/template/mmatica_logo.png" alt="mmatica"></a>
    </div>
    <div class="navbar pull-right">
        <div class="navbar-inner">
            <ul class="nav">
                <li><a href="#"><?=__('menu.blog')?></a></li>
                <li><a href="#"><?=__('menu.about')?></a></li>
                <li><a href="#"><?=__('menu.contacts')?></a></li>
            </ul>
            <ul class="nav pull-right">
                <?if ($user): ?>
                    <li class="dropdown">
                        <a href="<?=Route::url('user', array('action' => 'edit'))?>" class="dropdown-toggle" data-toggle="dropdown"><?=$user->email ? $user->email : __('global.my_profile')?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?=Route::url('default', array('controller' => 'user', 'action' => 'edit'))?>"><?=__('menu.main.page')?></a>
                            </li>
                            <?if ( $user->is_admin()):?>

                                <li>
                                    <a href="<?=Route::url('admin', array('controller' => 'admin'))?>"><?=__('menu.adm')?></a>
                                </li>
                            <?endif;?>
                        </ul>
                    </li>
                    <li><a href="<?=Route::url('user', array('action' => 'logout'))?>"><?=__('global.logout')?></a></li>
                <?else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=__('global.sign_in')?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <?=Request::factory(Route::url('user', array('action' => 'login')))->execute()?>
                            </li>
                        </ul>
                    </li>
                    <li><a href="<?=Route::url('user', array('action' => 'register'))?>"><?= __('global.registration')?></a ></li>
                <?endif;?>
            </ul>
        </div>
    </div>
</div><!-- /page-header -->