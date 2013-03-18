<div class="span6">
    <label><?=__('user.field.pay.'.$pay)?></label>
    <div class="row-fluid">
        <div class="span1">
            <input type="radio" name="pay" value="<?=$pay?>" <?=($user->pay == $pay) ? 'checked="checked"' : ''?>>
        </div>
        <div class="span11">
            <input type="text" class="input-block-level" name="<?=$in_name?>" value="<?=$user->get($in_name)?>">
        </div>
    </div>
	<?if ($pay == 'mobile'):?>
		<label><?=__('user.field.operator_name')?></label>
		<input class="input-block-level" type="text" name="operator_name" value="<?=$user->operator_name?>">
	<?elseif($pay == 'card'):?>
		<div class="row-fluid">
            <label><?=__('user.field.expiration')?></label>
			<div class="span2"><input class="input-block-level" type="text" name="expiration_mon" value="<?=$user->expiration_mon ? $user->expiration_mon : ''?>"></div>
            <div class="span2"><input class="input-block-level" type="text" name="expiration_year" value="<?=$user->expiration_year ? $user->expiration_year : ''?>"></div>
		</div>
	<?endif;?>
</div>