<p style="margin:20px 0 10px;">Similar <?=$resource?></p>
<?foreach($similar as $s):?>
<div>
	<p><?=$s->title?> - <?=$s->category->name?></p>
</div>
<?endforeach;?>