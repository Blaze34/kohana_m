<?=Form::open(NULL, array('class' => 'form-signin'))?>
    <h5 class="form-signin-heading"><?=__('auth.sign_in')?></h5>
    <input id="username" type="text" class="input-block-level" name="username" value="<?=Arr::get($_POST, 'username')?>">
    <input id="password" type="password" name="password" class="input-block-level">
    <label class="checkbox">
        <input type="checkbox" name="remember" value="1" checked="checked"> <?=__('auth.login.remember')?>
    </label>
    <button class="btn btn-large btn-primary btn-block" type="submit"><?=__('global.sign_in')?></button>
    <div>
        <a class="loginza" href="<?=$widget_url?>"></a>
    </div>

    <div class="recover">
        <a href="<?=Route::url('user', array('action' => 'recover'))?>"><?=__('auth.recover.password')?></a>
    </div>
<?=Form::close()?>

