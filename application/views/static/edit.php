<a class="btn btn-info adm_btn" href="<?=Route::url('static')?>"><?=__('global.go_back')?></a>
<div class="form_add">
    <?=Form::open(NULL, array('class' => 'form-horizontal'))?>
<div class="control-group">
    <label class="control-label"><?=__('static.title')?></label>
    <div class="controls">
        <input type="text" name="title" value="<?=$static->title?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label"><?=__('static.alias')?></label>
    <div class="controls">
        <div class="alias_label input-prepend input-append">
            <span class="add-on"><?=URL::site('', TRUE)?></span>
            <input class="alias" type="text" name="alias" value="<?=$static->alias?>">
            <span class="add-on">.html</span>
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label"><?=__('static.body')?></label>
    <div class="controls">
        <textarea class="tinymce" name="body"><?=$static->body?></textarea >
    </div>
</div>
<div class="control-group">
    <label class="control-label"><?=__('static.active')?></label>
    <div class="controls">
        <input type="checkbox" name="active" <?=$static->active ? 'checked="checked"' : '' ?>>
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

            // General options
            mode : "textareas",
            theme : "advanced",
            plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            // Theme options
            theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",

            theme_advanced_resizing : true,

            // Skin options
            skin : "o2k7",
            skin_variant : "blue",

            // Example content CSS (should be your site CSS)
            content_css : "css/example.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "js/template_list.js",
            external_link_list_url : "js/link_list.js",
            external_image_list_url : "js/image_list.js",
            media_external_list_url : "js/media_list.js",

            // Replace values for the template plugin
            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }
        });
    });
</script>

