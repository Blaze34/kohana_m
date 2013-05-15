<div class="admin settings">
    <h3>Администрирование сайта</h3>
    <h5>Общие настройки для сайта</h5>
    <?if (sizeof($settings)):?>
        <form action="" method="post">
            <table class="table table-hover" >
                <tr>
                    <th><strong>#</strong></th>
                    <th>Название</th>
                    <th class="nowrap">Вкл/Выкл</th>
                    <th><?=__('global.edit')?></th>
                </tr>
                <?$i = 1?>
                <?foreach ($settings as $s):?>
                    <tr class="<?=($s->status ? 'success' : 'error')?>">
                        <td><strong><?=$i++?></strong></td>
                        <td><?=$s->name?></td>
                        <td class="text-center"><input type="checkbox" name="<?=$s->title?>[status]" <?=($s->status ? 'checked="checked"' : '')?> /></td>
                        <td>
                            <?if ($s->form):?>
                            <a class="btn btn-warning btn-mini" href="<?=Route::url('default', array('controller' => 'admin', 'action' => 'edit', 'id' => $s->id()))?>" ><?=__('global.edit')?></a>
                            <?else:?>
                                <span class="btn btn-mini disabled"><?=__('global.edit')?></span>
                            <?endif;?>
                        </td>
                    </tr>
                <?endforeach;?>
            </table>
            <input type="hidden" name="setting" />
            <button type="submit" class="btn btn-success"><?=__('global.save')?></button>
        </form>
    <?endif;?>
</div>