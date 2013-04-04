<h3><?=__('title.formula.index')?></h3>
<?php if ( !sizeof($formula)):?>
    <p>No static pages</p>
<?php else: ?>
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
        <?php endforeach; ?>
    </table>
<? endif;?>