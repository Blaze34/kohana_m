<h3>Таблица материала с полями для сортировки</h3>
<?php if ( !sizeof($materials)):?>
    <p>ПУсто</p>
<?php else: ?>
    <div class="text-right">
        <a class="btn btn btn-info text-right" href="<?=Route::url('default', array('controller' => 'formula'))?>">Вернуться</a>
        <p></p>
    </div>
    <table class="table">
        <tr>
            <th>ID</th>

            <th>Название</th>
            <th>Лайки</th>
            <th>Дислайки</th>
            <th>Просмотров</th>
            <th>Комментариев</th>
            <th>Дней</th>
        </tr>
        <?foreach ($materials as $m):?>
            <tr>
                <td><?=$m->id()?></td>
                <td><?=$m->title?></td>
                <td><?=$m->likes?></td>
                <td><?=$m->dislikes?></td>
                <td><?=$m->views?></td>
                <td><?=$m->comments_count?></td>
                <td><?=$m->days?></td>
            </tr>
        <?endforeach; ?>
    </table>
    <?=isset($pagination) ? $pagination : ''?>
<? endif;?>