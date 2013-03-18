<div class="register">
<?=Form::open(NULL, array('class' => 'form-signin'))?>
    <h2 class="form-signin-heading"><?=__('title.user.register')?></h2>
    <div class="row-fluid">
        <?=View::factory('user/register/text')->set(array('user' => $user, 'field' => 'email', 'require' => TRUE));?>
        <div class="span6">
            <label for="reg_birthday"><?=__('user.field.birthday')?></label>
            <input id="reg_birthday" type="text" class="input-block-level datepicker" data-date-format="dd-mm-yyyy" name="birthday" value="<?=$user->birthday?>">
        </div>
    </div>
    <div class="row-fluid">
        <?=View::factory('user/register/password')->set(array('user' => $user, 'field' => 'password', 'require' => TRUE));?>
        <?=View::factory('user/register/password')->set(array('user' => $user, 'field' => 'password_confirm', 'require' => TRUE));?>
    </div>
    <div class="row-fluid">
        <?=View::factory('user/register/text')->set(array('user' => $user, 'field' => 'firstname'));?>
        <?=View::factory('user/register/text')->set(array('user' => $user, 'field' => 'lastname'));?>
    </div>
    <div class="row-fluid show-grid">
        <button class="btn btn-large btn-primary span6" type="submit"><?=__('global.registration')?></button>
        <a href="<?=Route::url('user', array('action' => 'login'))?>" class="btn btn-large span6"><?=__('global.sign_in')?></a>
    </div>
<?=Form::close()?>
</div>

