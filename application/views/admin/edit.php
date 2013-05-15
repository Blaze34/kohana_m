<h3><?=$setting->name?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'admin'))?>"><?=__('global.go_back')?></a></h3>

<div class="admin settings form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label">Значение</label>
        <div class="controls">
            <textarea name="<?=$setting->title?>"><?=$setting->value?></textarea>
        </div>
    </div>
    <?if($setting->help):?>
    <div class="control-group">
        <label class="control-label">Замечания</label>
        <div class="controls">
            <code><?=htmlspecialchars($setting->help)?></code>
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