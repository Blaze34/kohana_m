<a class="btn btn-info adm_btn" href="<?=Route::url('static')?>"><?=__('global.go_back')?></a>
<div class="post_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
<div class="control-group">
    <label class="control-label"><?=__('static.title')?></label>
    <div class="controls">
        <input type="text" name="title" value="<?=$static->title?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label"><?=__('static.alias')?></label>
    <div class="controls">
        <input type="text" name="alias" value="<?=$static->alies?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label"><?=__('static.body')?></label>
    <div class="controls">
        <?=Form::textarea('body', $static->body)?>
    </div>
</div>
<div class="control-group">
    <label class="control-label"><?=__('static.active')?></label>
    <div class="controls">
        <input type="checkbox" name="active" <?=$static->active ? 'checked="checked"' : '' ?>>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <button type="submit" class="btn"><?=__('static.create')?></button>
    </div>
</div>

<?=Form::close()?>
</div>

