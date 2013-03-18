<?$filters = Kohana::$config->load('user.filter');?>

<form action="<?=Route::url('user');?>">
	<div class="row-fluid">
		<?foreach($filters as $name => $param):?>
			<div class="span2">
				<label for="filter_<?=$name?>"><?=__('user.field.'.$name)?></label>
				<input type="text" name="<?=$name?>" id="filter_<?=$name?>" value="<?=Arr::get($_GET, $name)?>" class="input-block-level">
			</div>
		<?endforeach;?>
	</div>
    <div class="row-fluid">
	    <button type="submit" class="btn btn-primary span2"><?=__('global.apply')?></button>
	    <a href="<?=Route::url('user')?>" class="btn span2"><?=__('global.reset')?></a>
	</div>
</form>