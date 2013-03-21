<?if (sizeof($categories)):?>
    <div class="categories">
        <h3><?=__('adm.category')?><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'add'))?>" class="btn btn-success pull-right"><?=__('global.create')?></a ></h3>
        <?foreach ($categories as $cid => $c):?>
            <div class="well well-large">
                <h3 class="well-small bg-white">
                    <a class="btn btn-link main_section" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $cid))?>"><?=$c['name']?></a>
                <span class="span4 pull-right text-right">
                    <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'edit', 'id' => $cid))?>" ><?=__('global.edit')?></a>
                    <a class="btn btn-danger btn-mini" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'delete', 'id' => $cid))?>" ><?=__('global.delete')?></a>
                </span>
                </h3>
                <?if (sizeof($c['children'])):?>
                    <table class="table table-hover well bg-white">
                        <thead>
                        <tr>
                            <th><?=__('category.field.subcategory')?></th>
                            <th><?=__('category.field.sort')?></th>
                            <th><?=__('global.edit')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?foreach ($c['children'] as $child_id => $child):?>
                            <tr>
                                <td><a class="btn btn-link" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $child_id))?>"><?=$child['name']?></a></td>
                                <td><?=$child['sort']?></td>
                                <td>
                                    <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'edit', 'id' => $child_id))?>"><?=__('global.edit')?></a >
                                    <a class="btn btn-danger btn-mini" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'delete', 'id' => $cid))?>" ><?=__('global.delete')?></a >
                                </td>
                            </tr>
                        <?endforeach;?>
                        </tbody>
                    </table>
                <?endif;?>
            </div>
        <?endforeach;?>
    </div>
<?endif;?>