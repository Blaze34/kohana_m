<div class="span6">
	<label for="reg_<?=$field?>"><?=__('user.field.'.$field)?><?=(isset($require) AND $require) ? ' *' : ''?></label>
    <input id="reg_<?=$field?>" type="password" class="input-block-level" name="<?=$field?>" value="<?=Arr::get($_POST, $field)?>" autocomplete="off">
</div>