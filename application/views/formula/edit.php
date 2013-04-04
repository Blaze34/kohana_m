<h3><?=__('title.formula.edit')?> - <?=$formula->name?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'formula'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('formula.field.formula')?></label>
        <div class="controls">
            <input type="text" name="formula" value="<?=$formula->formula?>"/>
        </div>
        <div class="well" style="margin: 25px 0 0">
            Переменные, которые можна использовать в формуле:
            <ol>
                <li><strong>$L</strong> - Кол-во лайков(нравится) материала</li>
                <li><strong>$D</strong> - Кол-во дислайков(ненравится) материала</li>
                <li><strong>$T</strong> - Время в днях со дня опубликования</li>
                <li><strong>$C</strong> - Кол-во комментариев</li>
                <li><strong>$V</strong> - Кол-во просмотров</li>
            </ol>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('static.save')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>