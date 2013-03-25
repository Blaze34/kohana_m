<ul class="nav-list">
    <?foreach ($materials as $m):?>
        <li><a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $m['id']))?>"><?=$m['title']?></a></li>
    <?endforeach;?>
</ul>

