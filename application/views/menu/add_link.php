<h3><?=__('title.menu.add_link')?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'menu'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('menu.field.name')?></label>
        <div class="controls">
            <input type="text" name="name" value="<?=Arr::get($_POST, 'name')?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('menu.field.sort')?></label>
        <div class="controls">
            <div class="input-prepend">
                <input class="span2" type="text" name="sort" value="<?=Arr::get($_POST, 'sort')?>">
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('menu.field.url')?></label>
        <div class="controls">
            <div class="alias_label">
                <input class="span2" type="text" name="url" value="<?=Arr::get($_POST, 'url')?>">
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('global.save')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>

