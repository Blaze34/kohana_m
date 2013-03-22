<h2><?=__('title.user.edit')?></h2>
<?$me = A2::instance()->get_user();?>
<div class="edit_profile">
    <?=Form::open(Route::url('default', array('controller' => 'user', 'action' => 'avatar', 'id' => $user->id())), array('enctype' => 'multipart/form-data'))?>
    <div class="row-fluid">
        <div class="span2" style="text-align: center">
            <div class="thumbnail" style="width: 50px; height: 50px;">
                <a id="full_avatar" href="<?=$user->avatar('full').'?'.time();?>">
                    <img src="<?=$user->avatar('thumb').'?'.time();?>" />
                </a>
            </div>

            <?if ($user->avatar):?>
                <a href="<?=Route::url('default', array('controller' => 'user', 'action' => 'rma', 'id' => $user->id()))?>"  class="delete" rel="tooltip" data-placement="bottom" data-original-title="<?=__('user.avatar.delete')?>">
                    <span class="icon-remove"></span>
                </a>
            <?endif;?>
        </div>
        <div class="span10">
            <blockquote><?=__(
                    'user.avatar.hint.upload',
                    array(
                        ':allowed' => implode(', ', Kohana::$config->load('user.avatar.allowed')),
                        ':size' => Kohana::$config->load('user.avatar.size'),
                        ':width' => Kohana::$config->load('user.avatar.types.medium.width'),
                        ':height' => Kohana::$config->load('user.avatar.types.medium.height')
                    ));?>
            </blockquote>

            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3">
                        <i class="icon-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
					<span class="btn btn-file">
						<span class="fileupload-new"><?=__('global.choose.file')?></span>
						<span class="fileupload-exists"><?=__('global.change.file')?></span>
						<input type="file" name="avatar" />
					</span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload"><?=__('global.cancel')?></a>
                    <button class="btn btn-primary fileupload-exists" type="submit"><?=__('global.apply')?></button>
                </div>
            </div>
        </div>
    </div>
    <?=Form::close();?>

    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
        <div class="control-group">
            <label class="control-label" for="edit_email"><?=__('user.field.email')?></label>
            <div class="controls">
                <input id="edit_email" type="text" class="input-block-level" name="email" value="<?=$user->email?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="edit_firstname"><?=__('user.field.firstname')?></label>
            <div class="controls">
                <input id="edit_firstname" type="text" class="input-block-level" name="firstname" value="<?=$user->firstname?>">
            </div>
        </div>

    <div class="well well-small">Для смены пароля заполните поля ниже</div>

        <div class="control-group">
            <label class="control-label" for="edit_password"><?=__('user.field.password')?></label>
            <div class="controls">
                <input id="edit_password" type="password" class="input-block-level" name="password" value="<?=Arr::get($_POST, 'password')?>" autocomplete="off">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="edit_password_confirm"><?=__('user.field.password_confirm')?></label>
            <div class="controls">
                <input id="edit_password_confirm" type="password" class="input-block-level" name="password_confirm" value="<?=Arr::get($_POST, 'password_confirm')?>" autocomplete="off">
            </div>
        </div>

    <div class="show-grid">
        <button class="btn btn-large btn-primary" type="submit"><?=__('global.save')?></button>
        <button class="btn btn-large" type="reset"><?=__('global.reset')?></button>
        <button data-text="<?=__('user.delete.confirm.text')?>" data-href="<?=Route::url('default', array('controller' => 'user', 'action' => 'delete', 'id' => $user->id()))?>" class="btn btn-large btn-danger pull-right" role="button" data-action="confirm">
            <?=__('user.button.delete')?>
        </button>
    </div>

    <div id="modalDelete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel"><?=__('user.delete.confirm.title')?></h3>
        </div>
        <div class="modal-body">
            <?=__('user.delete.confirm.text')?>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true"><?=__('global.cancel')?></button>
            <a href="<?=Route::url('default', array('controller' => 'user', 'action' => 'delete', 'id' => $user->id()))?>" class="btn btn-primary"><?=__('global.confirm')?></a>
        </div>
    </div>

    <?=Form::close()?>
</div>

<script type="text/javascript">
	$(function(){

        $('#full_avatar').fancybox({
            openEffect	: 'elastic',
            closeEffect	: 'elastic'
        });
	})
</script>