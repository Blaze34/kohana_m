<div class="register_block">
<?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <h2 class="form-signin-heading"><?=__('title.user.register')?></h2>
    <?=View::factory('user/register/text')->set(array('user' => $user, 'field' => 'email', 'require' => TRUE));?>
    <?=View::factory('user/register/text')->set(array('user' => $user, 'field' => 'firstname', 'require' => TRUE));?>
    <?=View::factory('user/register/password')->set(array('user' => $user, 'field' => 'password', 'require' => TRUE));?>
    <?=View::factory('user/register/password')->set(array('user' => $user, 'field' => 'password_confirm', 'require' => TRUE));?>
    <div class="row-fluid show-grid">
        <button class="btn btn-large btn-primary span6" type="submit"><?=__('global.registration')?></button>
        <a href="<?=Route::url('user', array('action' => 'login'))?>" class="btn btn-large span6"><?=__('global.sign_in')?></a>
    </div>
<?=Form::close()?>
</div>

