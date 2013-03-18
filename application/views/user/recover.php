
<?=Form::open(NULL, array('class' => 'form-signin'))?>
		<label for="login_tf"><?=__('user.recover.tip')?></label>
		<input id="login_tf" type="text" name="username" class="input-block-level" value="<?=Arr::get($_POST, 'username')?>" />
		<div class="row-fluid">
            <button class="btn btn-primary btn-large span6" type="submit"><?=__('global.recover')?></button>
            <a class="btn span6 btn-large" href="<?=Route::url('user', array('action' => 'login'))?>"><?=__('global.cancel')?></a>
		</div>
<?=Form::close()?>