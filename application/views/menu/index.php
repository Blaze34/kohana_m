
    <div class="categories">
        <h3><?=__('adm.menu')?><a href="<?=Route::url('default', array('controller' => 'menu', 'action' => 'add_menu'))?>" class="btn btn-success pull-right"><?=__('menu.btn.add_menu')?></a ></h3>
        <?if (sizeof($menus)):?>
        <?foreach ($menus as $mid => $m):?>
            <div class="well well-large">
                <h3 class="well-small bg-white">
                    <?=$m?>
                    <span class="span7 pull-right text-right">
                        <a class="btn btn-success btn-mini" href="<?=Route::url('default', array('controller' => 'menu', 'action' => 'add_link', 'id' => $mid))?>"><?=__('menu.btn.add_link')?></a>
                        <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'menu', 'action' => 'edit_menu', 'id' => $mid))?>" ><?=__('global.edit')?></a>
                        <a class="btn btn-danger btn-mini alert_delete" data-href="<?=Route::url('default', array('controller' => 'menu', 'action' => 'delete?menu='.$mid))?>" href="javascript:;" ><?=__('global.delete')?></a>
                    </span>
                </h3>
                <?if (sizeof($links[$mid])):?>
                    <table class="table table-hover well bg-white">
                        <thead>
                        <tr>
                            <th><?=__('menu.field.link')?></th>
                            <th><?=__('menu.field.sort')?></th>
                            <th><?=__('global.edit')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?foreach ($links[$mid] as $lid => $l):?>
                            <tr>
                                <td><a class="btn btn-link" href="<?=$l['url']?>"><?=$l['name']?></a></td>
                                <td><?=$l['sort']?></td>
                                <td>
                                    <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'menu', 'action' => 'edit_link', 'id' => $lid))?>"><?=__('global.edit')?></a >
                                    <a class="btn btn-danger btn-mini alert_delete" data-href="<?=Route::url('default', array('controller' => 'menu', 'action' => 'delete?link='.$lid))?>" href="javascript;" ><?=__('global.delete')?></a >
                                </td>
                            </tr>
                        <?endforeach;?>
                        </tbody>
                    </table>
                    <div >
                        <h6>Для вставки меню поместите следующий код в нужное место:</h6>
                        <code>&lt;div class="navbar"&gt;&lt;?Menu::show(<?=$mid?>)?&gt;&lt;/div&gt;</code>
                    </div>
                <?endif;?>
            </div>
        <?endforeach;?>
        <?else:?>
            <?=__('error.list.empty')?>
        <?endif;?>
    </div>