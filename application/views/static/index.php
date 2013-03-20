<h3><?=__('title.static.index')?><a class="btn btn-success pull-right" href="<?=Route::url('static', array('action' => 'add'))?>"><?=__('global.create')?></a></h3>
<?php if ( !sizeof($statics)):?>
	<p>No static pages</p>
<?php else: ?>
    <table class="table table-striped">
        <tr>
            <th><?=__('static.title')?></th>
            <th><?=__('static.alias')?></th>
            <th><?=__('static.link')?></th>
            <th><?=__('static.actions')?></th>
        </tr>
        <?php foreach ($statics as $s):?>
            <tr>
                <td><?=$s->title?></td>
                <td><?=$s->alias?></td>
                <td><?=HTML::anchor(Route::url('static_view', array('alias' => $s->alias)))?></td>
                <td>
                    <a class="btn btn-mini btn-warning" href="<?=Route::url('static', array('action' => 'edit', 'id' => $s->id))?>"><?=__('static.edit')?></a>
                    <a class="btn btn-mini btn-danger" href="<?=Route::url('static', array('action' => 'delete', 'id' => $s->id))?>"><?=__('static.delete')?></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<? endif;?>