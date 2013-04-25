<?$user = A2::instance()->get_user();?>
<?if ( $user AND $user->allowed('static', 'edit')):?>
    <a href="<?=Route::url('static', array('action' => 'edit', 'id' => $static->id()))?>" class="btn btn-info adm_btn"><?=__('global.edit')?></a>
<?endif;?>
<h1><?=$static->title?></h1>
<?=$static->body?>

<?if($static->cant_comment):?>
    <?if($user AND $user->is_admin()) $admin = TRUE?>
    <div class="comments">
        <h4><?=__('comments.title')?></h4>
        <form class="form-horizontal" method="post" action="<?=Route::url('cmnt', array('action' => 'add', 'type' => $static->get_resource_id(),  'id' => $static->id()))?>">
            <div class="photo_frame square_42">
                <img src="<?=$user ? $user->avatar() : Jelly::factory('user')->avatar()?>" height="48" width="48" alt="">
            </div>
            <div class="msg">
                <textarea name="text"><?=Arr::get($_POST, 'text')?></textarea>
                <?if (!$user):?>
                    <br><br>
                    <input type="text" class="guest_name" name="guest_name" placeholder="Ваше имя" value="<?=Arr::get($_POST, 'guest_name')?>"/>
                    <input type="text" class="i-captcha" name="captcha" placeholder="Каптча"/>
                    <?=Captcha::instance('default')->render();?>
                <?endif;?>
                <button type="submit" class="btn btn-mini btn-primary pull-right">Отправить</button>
                <button type="reset" class="btn btn-mini pull-right">Очистить</button>
                <div class="clearfix"></div>
            </div>

        </form>

        <?if(sizeof($comments)):?>

            <script type="text/javascript">
                $(function(){
                    $('.answer').bind('click', function(e){
                        e.preventDefault();
                        var get_name = $(this).parents('.msg').find('.cmnt_author').text();
                        $('.comments .form-horizontal textarea').val(get_name + ', ');
                    })
                });
            </script>
            <ul>
                <?foreach ($comments as $c):?>
                    <li class="comment">
                        <div class="photo_frame square_42">
                            <?if($c->user->firstname):?>
                                <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $c->user->id))?>"><img src="<?=$c->user->avatar()?>" height="48" width="48" alt=""></a>
                            <?else:?>
                                <span><img src="<?=$c->user->avatar()?>" height="48" width="48" alt=""></span>
                            <?endif;?>
                        </div>
                        <div class="msg">
                            <div class="msg_topic">
                                <?=($c->user->firstname?'<a class="cmnt_author" href="'.Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $c->user->id)).'"><strong>'.$c->user->firstname.'</strong></a>': '<span class="cmnt_author"><strong>'.$c->guest_name.'</strong></span>')?>
                                <small class="pull-right"><?=Utils::convert_date($c->date)?> назад</small>
                            </div>
                            <div class="msg_txt">
                                <?=$c->text?>
                            </div>
                            <div class="msg_footer">
                                <a class="answer pull-left" href="#">Ответить</a>
                                <div class="buttons pull-right">
                                    <?=($admin?'<a href="javascript" data-href="'.Route::url('cmnt', array('action' => 'delete', 'type' => $static->get_resource_id(), 'id' => $c->id)).'" class="btn btn-mini btn-danger alert_delete"><i class="icon icon-remove icon-white"></i>'.__('global.delete').'</a>':'')?>
                                    <?if ($user AND ($c->user->firstname != $user->firstname)):?>
                                        <a href="<?=Route::url('vote', array('act' => 'like', 'type' => $c->get_resource_id(), 'id' => $c->id()))?>" class="btn btn-mini btn-success<?=($comments_user_vote[$c->id()]['like']) ? ' disabled' : ''?>">
                                            <i class="icon icon-thumbs-up icon-white"></i><?=($cpoll[$c->id()]['like'] ? $cpoll[$c->id()]['like']:'0')?>
                                        </a>
                                        <a href="<?=Route::url('vote', array('act' => 'dislike', 'type' => $c->get_resource_id(), 'id' => $c->id()))?>" class="btn btn-mini btn-warning<?=($comments_user_vote[$c->id()]['dislike']) ? ' disabled' : ''?>">
                                            <i class="icon icon-thumbs-down icon-white"></i><?=($cpoll[$c->id()]['dislike']?$cpoll[$c->id()]['dislike']:0)?>
                                        </a>
                                    <?endif;?>

                                </div>
                            </div>
                        </div>
                    </li>
                <?endforeach;?>
            </ul>
            <?=isset($pagination) ? $pagination : ''?>
        <?endif;?>
    </div><!-- /comments -->
<?endif;?>


