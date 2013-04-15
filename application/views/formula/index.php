<h3><?=__('title.formula.index')?></h3>
<?php if ( !sizeof($formula)):?>
    <p>ПУсто</p>
<?php else: ?>
    <div class="text-right">
        <a class="btn btn btn-primary text-right" href="<?=Route::url('default', array('controller' => 'formula', 'action' => 'materials'))?>">Таблица материала с полями для сортировки</a>
        <a class="btn btn btn-primary text-right" href="<?=Route::url('default', array('controller' => 'formula', 'action' => 'recount'))?>">Пересчитать поля</a>
        <p></p>
    </div>

    <table class="table table-striped">
        <tr>
            <th><?=__('formula.field.name')?></th>
            <th><?=__('formula.field.formula')?></th>
            <th></th>
        </tr>
        <?foreach ($formula as $f):?>
            <tr>
                <td><?=$f->name?></td>
                <td><?=$f->formula?></td>
                <td>
                    <a class="btn btn-mini btn-warning" href="<?=Route::url('default', array('controller' => 'formula', 'action' => 'edit', 'id' => $f->id))?>"><?=__('global.edit')?></a>
                </td>
            </tr>
        <?endforeach; ?>
    </table>
    <?=isset($pagination) ? $pagination : ''?>
<? endif;?>