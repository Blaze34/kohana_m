<div class="span3 last_comments">
    <div class="block_title"><?=__('comments.last.title')?></div>
    <?if(sizeof($comments)):?>
        <?
        $title_limit = Kohana::$config->load('comment.last.title_limit_words');
        $text_limit = Kohana::$config->load('comment.last.text_limit_words')
        ?>
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
</div><!-- /last_comments -->
<div class="span9 popular">
    <?$action = Request::current()->action();?>
    <div class="block_title">
        <?=$owner['firstname']?>
    </div>
    <div class="thum_items">
        <?if (sizeof($materials)):?>
        <ul class="thumbnails">
            <?foreach ($materials as $m):?>
                <?
                $comm = Arr::get($comments_count[$m->id()], 'count', 0);
                $like = Arr::get($polls[$m->id()], 'like', 0);
                $dislike = Arr::get($polls[$m->id()], 'dislike', 0)
                ?>
            <li class="thum_item">
                <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m->id()))?>" class="thumbnail">
                    <img src="/<?=$m->thumb()?>" alt="<?=$m->title?>"/>
                </a>
                <div class="item_txt">
                    <?=Text::limit_words($m->title, 15)?>
                </div>
                <div class="item_stat">Комм <?=$comm?>. &nbsp; <?=$like?><i class="icon-thumbs-up"></i>&nbsp;&nbsp; <?=$dislike?><i class="icon-thumbs-down"></i></div>
            </li>
            <?endforeach;?>
        </ul>
            <?else:?>
            <?=$owner['firstname']?> - не добавлял материал
        <?endif;?>
    </div>
</div>

