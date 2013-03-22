<script type="text/javascript">
    swfobject.embedSWF("/web/swf/player.swf", "player", "650", "440", "9.0.0", "/web/swf/expressInstall.swf", {begin: '<?=$material->start?>', end: '<?=$material->end?>', vid: '<?=$material->video?>'});
</script>

<ul class="breadcrumb">
    <li><a href="#">Удары</a> <span class="divider">/</span></li>
    <li><a href="#">Ваншоты</a> <span class="divider">/</span></li>
    <li class="active">Апперкот</li>
</ul>

<div class="sections">
    <h3><?=$material->category->name?></h3>
</div><!-- /sections -->

<div class="container-fluid">
<div class="row-fluid">
<div class="item_layout">
<div class="headline">
    <h2><?=$material->title?></h2>
</div>
<div class="span8">
    <div class="player">
        <div id="player"></div>
    </div>
    <div class="views-info">
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span>27592</span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span>2998</span></div>
        </div>
        <div class="buttons pull-right">
            <button class="btn btn-mini btn-success" type="button"><i class="icon icon-thumbs-up icon-white"></i>Нравится</button>
            <button class="btn btn-mini btn-warning" type="button"><i class="icon icon-thumbs-down icon-white"></i>Не нравится</button>
        </div>
        <div class="video-extras-sparkbars">
            <div class="video-extras-sparkbar-likes" style="width: 90%;"></div>
            <div class="video-extras-sparkbar-dislikes" style="width: 10%;"></div>
        </div>
    </div>

    <div class="user_header">
        <div class="pull-left">
            <i class="icon-user"></i>
            <a href="#"><?=$material->user->email?></a>
        </div>
        <div class="pull-right"><?=date('d.m.y', $material->date)?></div>
    </div>
    <div class="video_desc">
        <?=$material->description?>
    </div>
    <div class="video_footer">
        <div class="video_code pull-left">
            <textarea name="" id="" cols="30" rows="3"></textarea>
            <div class="help-block">Код видео</div>
        </div>
        <div class="share42init pull-right"></div>
    </div>
    <?
    $user = A2::instance()->get_user();
    if($user AND $user->is_admin()) $admin = TRUE;;
    ?>
    <div class="comments">
        <h4><?=__('comments.title')?></h4>
        <form class="form-horizontal" method="post" action="">
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
                    <?if($c->user->email):?>
                        <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $c->user->id))?>"><img src="<?=$c->user->avatar()?>" height="48" width="48" alt=""></a>
                    <?else:?>
                        <span><img src="<?=$c->user->avatar()?>" height="48" width="48" alt=""></span>
                    <?endif;?>
                </div>
                <div class="msg">
                    <div class="msg_topic">
                        <?=($c->user->email?'<a class="cmnt_author" href="'.Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $c->user->id)).'"><strong>'.$c->user->email.'</strong></a>': '<span class="cmnt_author"><strong>'.$c->guest_name.'</strong></span>')?>
                        <small class="pull-right"><?=date('d.m.y', $c->date)?></small>
                    </div>
                    <div class="msg_txt">
                        <?=$c->text?>
                    </div>
                    <div class="msg_footer">
                        <a class="answer pull-left" href="#">Ответить</a>
                        <div class="buttons pull-right">
                            <?=($admin?'<a href="'.Route::url('default', array('controller' => 'comment', 'action' => 'delete', 'id' => $c->id)).'" class="btn btn-mini btn-danger"><i class="icon icon-remove icon-white"></i>'.__('global.delete').'</a>':'')?>
                            <button class="btn btn-mini btn-success" type="button"><i class="icon icon-thumbs-up icon-white"></i> 15</button>
                            <button class="btn btn-mini btn-warning" type="button"><i class="icon icon-thumbs-down icon-white"></i>205</button>
                        </div>
                    </div>
                </div>
            </li>
            <?endforeach;?>
        </ul>
            <?=isset($pagination) ? $pagination : ''?>
        <?endif;?>
    </div><!-- /comments -->

</div><!-- /span8 -->
<div class="span4 related_videos">
    <div class="media">
        <a class="pull-left thumbnail" href="#">
            <img class="media-object" data-src="holder.js/120x70">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">С вертухи в щи</a></h4>
            <a href="#"><small>Terminator777</small></a>
        </div>
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span>27592</span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span>2998</span></div>
        </div>
    </div><!-- /media -->
    <div class="media">
        <a class="pull-left thumbnail" href="#">
            <img class="media-object" data-src="holder.js/120x70">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">С вертухи в щи asdasd as asdasd asd as</a></h4>
            <a href="#"><small>Terminator777</small></a>
        </div>
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span>27592</span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span>2998</span></div>
        </div>
    </div><!-- /media -->
    <div class="media">
        <a class="pull-left thumbnail" href="#">
            <img class="media-object" data-src="holder.js/120x70">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">С вертухи в щи</a></h4>
            <a href="#"><small>Terminator777</small></a>
        </div>
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span>27592</span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span>2998</span></div>
        </div>
    </div><!-- /media -->
    <div class="media">
        <a class="pull-left thumbnail" href="#">
            <img class="media-object" data-src="holder.js/120x70">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">С вертухи в щи</a></h4>
            <a href="#"><small>Terminator777</small></a>
        </div>
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span>27592</span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span>2998</span></div>
        </div>
    </div><!-- /media -->
    <div class="media">
        <a class="pull-left thumbnail" href="#">
            <img class="media-object" data-src="holder.js/120x70">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><a href="#">С вертухи в щи</a></h4>
            <a href="#"><small>Terminator777</small></a>
        </div>
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span>27592</span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span>2998</span></div>
        </div>
    </div><!-- /media -->
</div>
</div>
</div>
<div class="row-fluid">
    <div class="span12 block blog">
        <div class="block_title">Блог</div>
        <div class="txt_item">
            <div class="item_header"><a href="#">Монсон против Олейника</a></div>
            <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
        </div>
        <div class="txt_item">
            <div class="item_header"><a href="#">Монсон против Олейника</a></div>
            <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
        </div>
        <div class="txt_item">
            <div class="item_header"><a href="#">Монсон против Олейника</a></div>
            <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
        </div>
        <div class="txt_item">
            <div class="item_header"><a href="#">Монсон против Олейника</a></div>
            <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
        </div>
        <div class="txt_item">
            <div class="item_header"><a href="#">Монсон против Олейника</a></div>
            <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
        </div>
        <div class="txt_item">
            <div class="item_header"><a href="#">Монсон против Олейника</a></div>
            <div class="item_body">Интересно, скольким из вас приходилось хотя бы иногда,</div>
        </div>

    </div>
</div>
</div><!-- /container-fluid -->