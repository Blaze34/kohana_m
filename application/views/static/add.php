<a class="btn btn-info adm_btn" href="<?=Route::url('static')?>"><?=__('global.go_back')?></a>
<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('static.title')?></label>
        <div class="controls">
            <input type="text" name="title" value="<?=Arr::get($_POST, 'title')?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('static.alias')?></label>
        <div class="controls">
            <div class="alias_label input-prepend input-append">
                <span class="add-on"><?=URL::site('', TRUE)?></span>
                <input class="span2" type="text" name="alias" value="<?=Arr::get($_POST, 'alias')?>">
                <span class="add-on">.html</span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('static.body')?></label>
        <div class="controls">
            <textarea name="body"><?=Arr::get($_POST, 'body', '')?></textarea >
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('static.active')?></label>
        <div class="controls">
            <input type="checkbox" name="active">
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('static.create')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>

