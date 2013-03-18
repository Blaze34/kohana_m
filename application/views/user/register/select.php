<div class="span6">
	<label><?=__('user.field.'.$field)?><?=(isset($require) AND $require) ? ' *' : ''?></label>
    <select name="<?=$field?>" class="input-block-level">
        <option value=""><?=__('user.field.'.$field)?></option>
		<? foreach ($user->meta()->field($field)->choices as $k => $v):?>
            <option value="<?=$k?>" <?=($user->get($field) == $k) ? 'selected="selected"' : ''?>><?=__($v)?></option>
		<?endforeach;?>
    </select>
</div>