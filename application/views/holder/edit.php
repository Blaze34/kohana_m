<h3><?=__('title.holder.edit')?> - <?=$holder->title?><a class="btn btn-info pull-right" href="<?=Route::url('default', array('controller' => 'holder'))?>"><?=__('global.go_back')?></a></h3>

<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
    <div class="control-group">
        <label class="control-label"><?=__('category.field.name')?></label>
        <div class="controls">
            <input type="text" name="title" value="<?=$holder->title?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('holder.field.body')?></label>
        <div class="controls">
            <textarea class="tinymce" name="body"><?=$holder->body?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('holder.field.activity')?></label>
        <div class="controls">
            <input type="checkbox" name="activity" <?=$holder->activity ? 'checked="checked"' : '' ?>>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"><?=__('holder.field.category')?></label>
        <div class="controls">
            <?$cur_id = $holder->category->id()?>
            <select name="category">
                <option value="0">Не выбрана</option>
                <?foreach ($categories['parent'] as $sid => $s):?>
                    <option value="<?=$sid?>" <?=($sid == $cur_id ? 'selected="selected"' : '')?>><?=$s?></option>
                    <?if(sizeof($categories['children'][$s])):?>
                        <?foreach ($categories['children'][$s] as $cid =>  $ch):?>
                            <option value="<?=$cid?>" <?=($cid == $cur_id ? 'selected="selected"' : '')?>>&nbsp;&nbsp;&nbsp;<?=$ch?></option>
                        <?endforeach;?>
                    <?endif;?>
                <?endforeach;?>
            </select>
            <?//=Form::select('category', array(0 => 'Не выбрана') + $categories, $holder->category->id())?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn"><?=__('static.save')?></button>
        </div>
    </div>

    <?=Form::close()?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.tinymce').tinymce({
            script_url : '/web/js/tinymce/tiny_mce.js',
            mode : "textareas",
            theme : "advanced",
            plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|fontselect,fontsizeselect,|cut,copy,paste,|search,replace,|,bullist,numlist,|,outdent,indent,blockquote,",
            theme_advanced_buttons2 : "undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|fullscreen",
            theme_advanced_resizing : true,
            skin : "o2k7",
            skin_variant : "blue",
            content_css : "css/example.css",

            theme_advanced_resizing_max_width: '547',
            theme_advanced_resizing_min_height: '380'
        });
    });
</script>
