<?Holder::show(1, array('class' => 'test', 'style' => array('width' => '300px', 'height' => '200px')))?>
<div class="categories">
        <h3><?=__('adm.holder')?><a href="<?=Route::url('default', array('controller' => 'holder', 'action' => 'add'))?>" class="btn btn-success pull-right"><?=__('global.add')?></a ></h3>
        <?if (sizeof($holders)):?>
        <table class="table table-hover well bg-white">
            <thead>
            <tr>
                <th><?=__('holder.field.title')?></th>
                <th><?=__('holder.field.code')?></th>
                <th><?=__('holder.field.activity')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($holders as $h):?>
                <tr>
                    <td><?=$h->title?></td>
                    <td>
                    <?if ($h->activity):?>
                        <code>&lt;?Holder::show(<?=$h->id()?>)?&gt;</code>
                    <?else:?>
                            <p>Что бы использовать эту область, включите ее!</p>
                    <?endif;?>
                    </td>
                    <td><?=($h->activity ? '<i class="icon-ok"></i>' : '<i class="icon-off"></i>')?></td>
                    <td>
                        <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'holder', 'action' => 'edit', 'id' => $h->id()))?>"><?=__('global.edit')?></a >

                        <a class="btn btn-danger btn-mini alert_delete" data-href="<?=Route::url('default', array('controller' => 'holder', 'action' => 'delete', 'id' => $h->id()))?>" href="javascript;" ><?=__('global.delete')?></a >
                    </td>
                </tr>
            <?endforeach;?>
            </tbody>
        </table>

        <?else:?>
            <?=__('error.list.empty')?>
        <?endif;?>
</div>