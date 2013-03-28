<h3><?=__('title.menu.edit_menu')?> - <?=$menu->name?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'menu'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.name')?></label>
        <div class="controls">
            <input type="text" name="name" value="<?=$menu->name?>">
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('static.save')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>

