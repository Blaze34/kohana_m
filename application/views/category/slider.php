<?//=Debug::vars($categories)?>
<?$limit = Kohana::$config->load('category.slider_max_item')?>
<?if (sizeof($categories)):?>
    <div class="bxslider">
        <ul>
            <?foreach ($categories as $cid => $c):?>
            <li>
                <?$detail = Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $cid));?>
                <h4><a href="<?=$detail?>"><?=$c['name']?></a></h4>
                <ul>
                    <?
                    $show_more = FALSE;
                    if(sizeof($c['children']) > $limit)
                    {
                        $c['children'] = array_slice($c['children'], 0 , $limit - 1, TRUE);
                        $show_more = TRUE;
                    }
                    foreach ($c['children'] as $id => $child):?>
                        <li><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $id))?>"><?=$child?></a></li>
                    <?endforeach;?>

                    <?if ($show_more):?>
                        <li class="more"><a href="<?=$detail?>">Еще</a></li>
                    <?endif;?>
                </ul>
            </li>
            <?endforeach?>
        </ul>
    </div><!-- /bxslider -->
<?endif;?>

