<?if(sizeof($holder)):?>
    <?Holder::show($holder->id(), $holder->category->id())?>
<?endif;?>
<?Holder::show(13)?>
<div class="sections">
    <div class="title"><h1><?=$category->name?></h1></div>
    <?$id = Request::initial()->param('id')?>
    <ul>
        <?foreach ($children as $c):?>
            <?if ($id == $c->id()):?>
                <li class="active"><?=$c->name?></li>
            <?else:?>
                <li><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $c->id()))?>" ><?=$c->name?></a></li>
            <?endif?>
        <?endforeach;?>
    </ul>
</div>

<?if($materials):?>
<div class="container-fluid">
    <div class="row-fluid">
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
            <div class="block_title">Популярное
                <ul class="sort_by pull-right">
                    <li class="active"><a href="?popular">Популярные</a><span>/</span></li>
                    <li><a href="?commented">Комментируемые</a><span>/</span></li>
                </ul>
            </div>
            <div class="media_items">
                <?if(sizeof($materials)):?>
                    <?foreach($materials as $m):?>
                        <div class="media">
                            <a class="pull-left thumbnail" href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m->id()))?>">
                                <img class="media-object" src="/<?=$m->thumb()?>">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m->id()))?>"><?=$m->title?></a></h4>
                                <div class="author">
                                    <ul>
                                        <li><span>&bull;</span>
                                            <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $m->user->id()))?>"><strong><?=$m->user->firstname?></strong></a>
                                        </li>
                                        <li><span>&bull;</span><?=date('d.m.y', $m->date)?></li>
                                    </ul>
                                </div>
                                <div class="media_desc">
                                    <?=Text::limit_words($m->description, 30)?>
                                </div>
                            </div>
                        </div><!-- /media -->
                    <?endforeach;?>
                    <?=isset($pagination) ? $pagination : ''?>
                <?else:?>
                    Список пуст
                <?endif?>
            </div>
        </div><!-- /popular -->

        <div class="span12 block blog">
            <div class="block_title">Блог</div>
            <div class="txt_item">
                <div class="item_header"><a href="#">Монсон против Олейника</a></div>
                <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
            </div>
            <div class="txt_item">
                <div class="item_header"><a href="#">Монсон против Олейника</a></div>
                <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
            </div>
            <div class="txt_item">
                <div class="item_header"><a href="#">Монсон против Олейника</a></div>
                <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
            </div>
            <div class="txt_item">
                <div class="item_header"><a href="#">Монсон против Олейника</a></div>
                <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
            </div>
            <div class="txt_item">
                <div class="item_header"><a href="#">Монсон против Олейника</a></div>
                <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
            </div>
            <div class="txt_item">
                <div class="item_header"><a href="#">Монсон против Олейника</a></div>
                <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
            </div>

        </div>
    </div>
</div><!-- /container-fluid -->
<?endif?>