<?if(sizeof($speedbar)):?>
<div class="speedbar">

    <a href="/"><?=__('speedbar.index')?></a>

    <?foreach($speedbar as $item):?>
        <span>&rarr;</span>
        <?foreach($item as $title => $url):?>
			<a href="<?=$url?>" class="<?=$item == $speedbar[sizeof($speedbar)-1] ? 'last' : ''?>"><?=__($title)?></a>
        <?endforeach;?>
    <?endforeach;?>

</div>
<?endif;?>