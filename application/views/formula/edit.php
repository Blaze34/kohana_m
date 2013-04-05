<h3><?=__('title.formula.edit')?> - <?=$formula->name?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'formula'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('formula.field.formula')?></label>
        <div class="controls">
            <input type="text" name="formula" value="<?=($check_formula['calculate'] ? $check_formula['formula'] : $formula->formula)?>"/>
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

            <p>При нажатии на кноку "Проверить" в формулу будут подставлены такие значения:</p>
            <ol>
                <li><strong>$L</strong> - 10</li>
                <li><strong>$D</strong> - 2</li>
                <li><strong>$T</strong> - 2</li>
                <li><strong>$C</strong> - 12</li>
                <li><strong>$V</strong> - 24</li>
            </ol>
            <?if($check_formula):?>
                <p>Результат по формуле: <strong><?=$check_formula['formula']?> = <?=$check_formula['calculate']?></strong></p>
            <?endif;?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" name="check" class="btn"><?=__('global.check')?></button>
            <button type="submit" name="save" class="btn"><?=__('global.save')?></button>
        </div>
    </div>
    <?=Form::close()?>
</div>