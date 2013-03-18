<?if (sizeof($resources_id)):
	foreach ($resources_id as $id):?>
		<div>
			<?=$resource?> - with id <?=$id?>
			<br />
		</div>
	<?endforeach;
else:?>
	No <?=$resource?> found
<?endif;?>