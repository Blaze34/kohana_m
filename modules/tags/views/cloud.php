<div class="tags_cloud">
	<?foreach($tags as $tag):?>
		<a href="<?=Route::url('tags', array('name' => $tag['name'], 'resource' => $resource))?>" title=" <?=$tag['count']?> " style="font-size:<?=Arr::get($counts, $tag['count'])?>px"><?=$tag['name']?></a>
	<?endforeach;?>
</div>
