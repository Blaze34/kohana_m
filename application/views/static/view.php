<?$user = A2::instance()->get_user();?>
<?if ( $user AND $user->allowed('static', 'edit')):?>
    <a href="<?=Route::url('static', array('action' => 'edit', 'id' => $static->id()))?>" class="btn btn-info adm_btn"><?=__('global.edit')?></a>
<?endif;?>
<h1><?=$static->title?></h1>
<?=$static->body?>

