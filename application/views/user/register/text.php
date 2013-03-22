<div class="control-group">
    <label class="control-label" for="reg_<?=$field?>"><?=__('user.field.'.$field)?><?=(isset($require) AND $require) ? ' *' : ''?></label>
    <div class="controls">
        <input id="reg_<?=$field?>" type="text" class="input-block-level" name="<?=$field?>" value="<?=$user->get($field)?>">
    </div>
</div>