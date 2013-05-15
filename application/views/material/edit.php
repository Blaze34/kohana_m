<script type="text/javascript">
    function setLimit(begin, end)
    {
        $("#video_start").val(begin);
        $("#video_end").val(end);
    }
    $(document).ready(function(){
        swfobject.embedSWF("/web/swf/cut.swf", "player", "746", "440", "9.0.0", "/web/swf/expressInstall.swf", {begin: '<?=$material->start?>', end: '<?=$material->end?>', vid: '<?=$material->video?>'});
    });
</script>
<div class="add_layout">
    <div class="add_block edit_wrapper admin material">
        <div class="wrapper player" style="text-align: center">
            <?if($material->video):?>
                <div id="player"></div>
            <?else:?>
                <img src="/<?=$material->file()?>" alt=""/>
            <?endif;?>
        </div>
        <div class="wrapper">
            <form action="" class="form-horizontal" method="post">
                <input name="start" type="hidden" id="video_start" value>
                <input name="end" type="hidden" id="video_end" value>

                <div class="control-group">
                    <label class="control-label"><?=__('material.field.title')?> <sup>*</sup></label>
                    <div class="controls">
                        <input name="title" type="text" placeholder="Заголовок" value="<?=$material->title?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?=__('material.field.meta_title')?></label>
                    <div class="controls">
                        <input name="meta_title" type="text" placeholder="Мета" value="<?=$material->meta_title?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Выбрать категорию<sup>*</sup></label>
                    <div class="controls">
                        <select name="categories[]" multiple="multiple">
                            <option value="0">Не выбрана</option>
                            <?foreach ($categories['parent'] as $sid => $s):?>
                                <option value="<?=$sid?>" <?=(in_array($sid, $categories['current']) ? 'selected="selected"' : '')?>><?=$s?></option>
                                <?if(sizeof($categories['children'][$s])):?>
                                    <?foreach ($categories['children'][$s] as $cid =>  $ch):?>
                                        <option value="<?=$cid?>" <?=(in_array($cid, $categories['current']) ? 'selected="selected"' : '')?>>&nbsp;&nbsp;&nbsp;<?=$ch?></option>
                                    <?endforeach;?>
                                <?endif;?>
                            <?endforeach;?>
                        </select>
<!--                        --><?//=Form::select('category', array(0 => 'Не выбрана') + $category_options, $material->category->id(), array('multiple'))?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Добавить описание</label>
                    <div class="controls">
                        <textarea name="description" rows="3"><?=$material->description?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">meta-description</label>
                    <div class="controls">
                        <textarea class="meta_desc" name="meta_desc" rows="3"><?=$material->meta_desc?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Теги</label>
                    <div class="controls">
                        <?=Tags::field($material)?>
                        <div class="help-block">Введите теги через запятую</div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Показывать на главной</label>
                    <div class="controls">
                        <input type="checkbox" name="on_index" <?=$material->on_index ? 'checked="checked"' : '' ?>>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Отправить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>