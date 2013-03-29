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
    <?else:?>
        Рельтат поиска пуст
    <?endif?>
    <?=isset($pagination) ? $pagination : ''?>
</div>