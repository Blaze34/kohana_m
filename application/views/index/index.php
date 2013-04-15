<?$user = A2::instance()->get_user();?>
<div class="span3">
    <?=Request::factory(Route::url('default', array('controller' => 'comment', 'action' => 'last')))->execute()?>
</div>
<div class="span9 popular">
    <div class="block_title">Популярное</div>
    <div class="thum_items">
        <?if (sizeof($_popular['materials'])):?>
            <ul class="thumbnails">
                <?foreach ($_popular['materials'] as $m):?>
                    <?
                    $comm = Arr::get($_popular['comments'][$m->id()], 'count', 0);
                    $like = Arr::get($_popular['polls'][$m->id()], 'like', 0);
                    $dislike = Arr::get($_popular['polls'][$m->id()], 'dislike', 0)
                    ?>
                    <li class="thum_item">
                        <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m->id()))?>" class="thumbnail">
                            <img src="/<?=$m->thumb()?>" alt="<?=$m->title?>"/>
                        </a>
                        <?if($user AND $user->is_admin()):?>
                            <div class="hide_from_page"><a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'onindex', 'id' => $m->id()))?>"><i class="icon-remove"></i> Убрать с главной</a></div>
                        <?endif;?>
                        <div class="item_txt">
                            <?=Text::limit_words($m->title, 15)?>
                        </div>
                        <div class="item_stat">Комм <?=$comm?>. &nbsp; <?=$like?><i class="icon-thumbs-up"></i>&nbsp;&nbsp; <?=$dislike?><i class="icon-thumbs-down"></i></div>
                    </li>
                <?endforeach;?>
            </ul>
            <?=isset($pagination) ? $pagination : ''?>
        <?else : ?>
            Список пуст
        <?endif;?>
    </div>
</div>
<?Holder::show(12, NULL, array('wrapper' => false))?>
<div class="span12 block popular novelty">
    <div class="block_title">Новинки</div>
    <div class="thum_items">
        <?if (sizeof($_novelty['materials'])):?>
            <ul class="thumbnails">
                <?foreach ($_novelty['materials'] as $m):?>
                    <?
                    $comm = Arr::get($_novelty['comments'][$m->id()], 'count', 0);
                    $like = Arr::get($_novelty['polls'][$m->id()], 'like', 0);
                    $dislike = Arr::get($_novelty['polls'][$m->id()], 'dislike', 0)
                    ?>
                    <li class="thum_item">
                        <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m->id()))?>" class="thumbnail">
                            <img src="/<?=$m->thumb()?>" alt="<?=$m->title?>"/>
                        </a>
                        <?if($user AND $user->is_admin()):?>
                            <div class="hide_from_page"><a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'onindex', 'id' => $m->id()))?>"><i class="icon-remove"></i> Убрать с главной</a></div>
                        <?endif;?>
                        <div class="item_txt">
                            <?=Text::limit_words($m->title, 15)?>
                        </div>
                        <div class="item_stat">Комм <?=$comm?>. &nbsp; <?=$like?><i class="icon-thumbs-up"></i>&nbsp;&nbsp; <?=$dislike?><i class="icon-thumbs-down"></i></div>
                    </li>
                <?endforeach;?>
            </ul>
            <?=isset($pagination) ? $pagination : ''?>
        <?else : ?>
            Список пуст
        <?endif;?>
    </div>
</div>


