<? if (sizeof($tags)): ?>
    <div class="taglist"><?=__('tags.label')?>:
	<?for(reset($tags); current($tags); ):?>
		<a href="<?=Route::url('tags', array('name' => current($tags), 'resource' => $resource))?>"><?=current($tags)?></a><?=(next($tags)) ? $sep : ''?>
	<?endfor;?>
    </div>
<? endif;?>