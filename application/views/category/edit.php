<h3><?=__('adm.category.edit')?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'category'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.title')?></label>
        <div class="controls">
            <input type="text" name="title" value="<?=$category->title?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.meta_title')?></label>
        <div class="controls">
            <input type="text" name="meta_title" value="<?=$category->meta_title?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.mask_title')?></label>
        <div class="controls">
            <input type="text" name="mask_title" value="<?=$category->mask_title?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.meta_desc')?></label>
        <div class="controls">
            <textarea name="meta_desc" ><?=$category->meta_desc?></textarea>
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

    <?if ($category->parent_id):?>
        <div class="control-group">
            <label class="control-label"><?=__('category.field.parent')?></label>
            <div class="controls">
                <?=Form::select('parent_id', $categories, (Arr::get($_POST, 'parent_id')?Arr::get($_POST, 'parent_id'):$category->parent_id))?>
            </div>
        </div>
    <?endif;?>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('static.save')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>

