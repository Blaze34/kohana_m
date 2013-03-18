<?=HTML::anchor(Route::url('static', array('action' => 'add')), __('static.Create'))?>
<?php if ( !sizeof($statics)):?>
	<p>No static pages</p>
<?php else: ?>
	<table width="100%" cellspacing="0">
	<tr>
		<th align="left"><?=__('static.Title')?></th>
		<th align="left"><?=__('static.Alias')?></th>
		<th align="left"><?=__('static.Link')?></th>
		<th align="left"><?=__('static.Actions')?></th>
	</tr>
	<?php foreach ($statics as $s):?>
		<tr>
			<td><?=$s->title?></td>
			<td><?=$s->alias?></td>
			<td><?=HTML::anchor(Route::url('static_view', array('alias' => $s->alias)))?></td>
			<td>
				[ <?=HTML::anchor(Route::url('static', array('action' => 'edit', 'id' => $s->id)), __('static.Edit'))?> ]
				[ <?=HTML::anchor(Route::url('static', array('action' => 'delete', 'id' => $s->id)), __('static.Delete'), array('class' => 'delete'))?> ]
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<? endif;?>