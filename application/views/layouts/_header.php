<?$user = A2::instance()->get_user();?>
<div class="page-header">
    <div class="site_logo pull-left">
        <a href="/"><img src="/web/img/template/logo.png" alt="mmatica"></a>
    </div>
    <div class="navbar pull-left top_menu">
        <?Menu::show(1)?>
    </div>
    <div class="navbar pull-right user_panel">
        <div class="navbar-inner">
            <ul class="nav pull-right">
                <?if ($user): ?>
                    <li class="dropdown">
                        <div class="dropdown-toggle is_login" data-toggle="dropdown">
                            <div class="user_photo pull-left" style="width: 30px; height: 30px;">
                                <a id="full_avatar" href="<?=$user->avatar('full').'?'.time();?>">
                                    <img src="<?=$user->avatar('thumb').'?'.time();?>" />
                                </a>
                            </div>
                            <span><?=$user->email ? $user->email : __('global.my_profile')?><b class="caret"></b></span>
                        </div>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?=Route::url('default', array('controller' => 'user', 'action' => 'edit'))?>"><?=__('menu.main.page')?></a>
                            </li>
                            <?if ( $user->is_admin()):?>

                                <li>
                                    <a href="<?=Route::url('admin', array('controller' => 'admin'))?>"><?=__('menu.adm')?></a>
                                </li>
                            <?endif;?>
                            <li><a href="<?=Route::url('user', array('action' => 'logout'))?>"><?=__('global.logout')?></a></li>
                        </ul>
                    </li>
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