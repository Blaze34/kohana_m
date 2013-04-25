<h3><?=__('adm.category.edit')?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'category'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.name')?></label>
        <div class="controls">
            <input type="text" name="name" value="<?=$category->name?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.meta_title')?></label>
        <div class="controls">
            <input type="text" name="meta_title" value="<?=$category->meta_title?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.sort')?></label>
        <div class="controls">
            <div class="input-prepend">
                <input class="span2" type="text" name="sort" value="<?=$category->sort?>">
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.parent')?></label>
        <div class="controls">
            <?=Form::select('parent_id', array(0 => 'Не выбрана') + $categories, Arr::get($_POST, 'parent_id'))?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('static.save')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>

