<div class="span3">
    <?=Request::factory(Route::url('default', array('controller' => 'comment', 'action' => 'last')))->execute()?>
</div>