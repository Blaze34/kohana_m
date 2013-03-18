<?if (sizeof($resources)):?>
	<?foreach ($resources as $resource):?>
		<div>
			Name: <strong><?=$resource->title;?></strong><br />
			Price: <strong><?=$resource->price;?></strong><br />
			Category: <strong><?=$resource->category->name?></strong><br />
			Description: <br />
			<?=$resource->description;?>
		</div>
	<?endforeach;?>
<?else:?>
	No <?=$resource?> found
<?endif;?>