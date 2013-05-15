<div class="categories admin">
    <h3><?=__('adm.category')?><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'add'))?>" class="btn btn-success pull-right"><?=__('global.create')?></a ></h3>
    <?if (sizeof($categories)):?>
    <?foreach ($categories as $cid => $c):?>
        <div class="well well-large">
            <table class="table well bg-white">
                <tr>
                    <td>
                        <h3 class="well-small">
                            <a class="btn btn-link main_section" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $cid))?>"><?=$c['title']?></a>
                        </h3>
                    </td>
                    <td><?=$c['sort']?></td>
                    <td class="text-right">
                        <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'edit', 'id' => $cid))?>" ><?=__('global.edit')?></a>
                        <a class="btn btn-danger btn-mini alert_delete" href="javascript:;" data-href="<?=Route::url('default', array('controller' => 'category', 'action' => 'delete', 'id' => $cid))?>" ><?=__('global.delete')?></a>
                    </td>
                </tr>
            <?if (sizeof($c['children'])):?>
                <table class="table table-hover well bg-white">
                    <thead>
                    <tr>
                        <th><?=__('category.field.subcategory')?></th>
                        <th><?=__('category.field.sort')?></th>
                        <th class="text-right"><?=__('global.edit')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach ($c['children'] as $child_id => $child):?>
                        <tr>
                            <td><a class="btn btn-link" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $child_id))?>"><?=$child['title']?></a></td>
                            <td><?=$child['sort']?></td>
                            <td class="text-right">
                                <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'edit', 'id' => $child_id))?>"><?=__('global.edit')?></a >
                                <a class="btn btn-danger btn-mini alert_delete"  href="javascript:;" data-href="<?=Route::url('default', array('controller' => 'category', 'action' => 'delete', 'id' => $child_id))?>" ><?=__('global.delete')?></a >
                            </td>
                        </tr>
                    <?endforeach;?>
                    </tbody>
                </table>
            <?endif;?>
            </table>
        </div>
    <?endforeach;?>
    <?else:?>
        <?=__('error.list.empty')?>
    <?endif;?>
</div>