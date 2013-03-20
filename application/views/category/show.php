<h3><?=$category->name?></h3>
<ul>
    <?foreach ($category->children as $c):?>
    <li><a class="btn btn-link" href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $c->id()))?>" ><?=$c->name?></a></li>
    <?endforeach;?>
</ul>