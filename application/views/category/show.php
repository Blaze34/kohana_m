<div class="sections">
    <h3><?=$category->name?></h3>
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
<?if(isset($materials)):?>
<div class="well well_hr">
    <!--<img src="holder.js/980x120" alt="">-->
    Брошенная бутылка при столкновении с объектом лопается, горящая жидкость шустро пропитывает всё, на чём оседает. Одноразовый бюджетный вариант огнемёта. Просто, со вкусом и эффективно. Кроме того, бомба предрасположена к апгрейдам, и при добавлении некоторых нехитрых веществ способна гореть жарче и производить очень едкий густой дым, оказывающий довящее действие на врага, сильно препятствуя обзору и заставляя его испытывать глубокий психологический дискомфорт. Температура горения подобного коктейля доходит до 1600 градусов, а пламя невозможно потушить водой. Применялась для подавления дзотов, окопов и прочих подвалов.
</div><!-- /holder_hr -->
<div class="container-fluid">
    <div class="row-fluid">
        <?=Request::factory(Route::url('default', array('controller' => 'comment', 'action' => 'last')))->execute()?>
            <div class="span9 popular">
                <div class="block_title">Популярное
                    <ul class="sort_by pull-right">
                        <li class="active"><a href="?popular">Популярные</a><span>/</span></li>
                        <li><a href="?commented">Комментируемые</a><span>/</span></li>
                    </ul>
                </div>
                <div class="well_block well_rt pull-right">
                    <div class="well">
                        Брошенная бутылка при столкновении с объектом лопается, горящая жидкость шустро пропитывает всё, на чём оседает.
                        <!--<img data-src="holder.js/162x300" alt="">-->
                    </div>
                    <div class="well">
                        <img data-src="holder.js/143x250" alt="">
                    </div>
                </div>
                <div class="media_items">
                    <?if(sizeof($materials)):?>
                        <?foreach($materials as $m):?>
                            <div class="media">
                                <a class="pull-left thumbnail" href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m->id()))?>">
                                    <img class="media-object" src="/<?=$m->thumb()?>">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#"><?=$m->name?></a></h4>
                                    <div class="author">
                                        <ul>
                                            <li><span>&bull;</span>
                                                <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $m->user->id()))?>"><strong><?=$m->user->firstname?></strong></a>
                                            </li>
                                            <li><span>&bull;</span><?=date('d.m.y', $m->date)?></li>
                                        </ul>
                                    </div>
                                    <div class="media_desc">
                                        <?=Text::limit_words($m->description, 25)?>
                                    </div>
                                </div>
                            </div><!-- /media -->
                        <?endforeach;?>
                    <?else:?>
                        Список пуст
                    <?endif?>
                    <?=isset($pagination) ? $pagination : ''?>
                </div>
            </div>
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