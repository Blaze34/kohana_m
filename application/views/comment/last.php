<div class="span12 last_comments">
    <div class="block_title"><?=__('comments.last.title')?></div>
    <?if(sizeof($comments)):?>
    <?$title_limit = Kohana::$config->load('comment.last.title_limit_words');
    $text_limit = Kohana::$config->load('comment.last.text_limit_words')?>
        <?foreach ($comments as $c):?>
        <div class="txt_item">
            <div class="item_header"><a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $c->material->id))?>"><?=Text::limit_words($c->material->title, $title_limit)?></a></div>
            <div class="item_body"><?=Text::limit_words($c->text, $text_limit)?></div>
            <div class="item_footer">
                <?=($c->user->email?'<a href="'.Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $c->user->id())).'">'.$c->user->firstname.'</a>':''.$c->guest_name)?>
                <span><?=Utils::convert_date($c->date)?> назад</span>
            </div>
        </div>
        <?endforeach?>
        <?else:?>
        <div class="txt_item"><?=__('comments.last.empty')?></div>
    <?endif;?>
    <?Holder::show(6, array('class' => 'well_vr'))?>
</div>