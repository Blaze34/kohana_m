<div class="navbar-inner">
    <ul class="nav">
    <?foreach ($links as $l):?>
        <li><a href="<?=$l->url?>"><?=$l->name?></a></li>
    <?endforeach;?>
    </ul>
</div>