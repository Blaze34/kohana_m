<h3>Администрирование сайта</h3>
<h5>Общие настройки для сайта</h5>
<?if (sizeof($settings)):?>
    <form action="" method="post">
        <table class="table table-hover" >
            <?foreach ($settings as $s):?>
                <tr class="<?=($s->status ? 'success' : 'error')?>">
                    <td><?=$s->name?></td>
                    <td><input type="checkbox" name="<?=$s->title?>" <?=($s->status ? 'checked="checked"' : '')?> /></td>
                </tr>
            <?endforeach;?>
        </table>
        <input type="hidden" name="settings"/>
        <button type="submit" class="btn btn-success"><?=__('global.save')?></button>
    </form>
<?endif;?>
