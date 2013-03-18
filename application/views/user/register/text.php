<div class="span6">
	<label for="reg_<?=$field?>"><?=__('user.field.'.$field)?><?=(isset($require) AND $require) ? ' *' : ''?></label>
    <input id="reg_<?=$field?>" type="text" class="input-block-level" name="<?=$field?>" value="<?=$user->get($field)?>">
</div>