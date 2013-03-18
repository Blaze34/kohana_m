<div class="well well-large">
    Здесь будет главная страница!!!
</div>

<div class="span3">
    <?=Request::factory(Route::url('default', array('controller' => 'comment', 'action' => 'last')))->execute()?>
</div>