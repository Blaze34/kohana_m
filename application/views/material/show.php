<script type="text/javascript">
    swfobject.embedSWF("/web/swf/player.swf", "player", "650", "440", "9.0.0", "/web/swf/expressInstall.swf", {begin: '<?=$material->start?>', end: '<?=$material->end?>', vid: '<?=$material->video?>'});
</script>
<?$parent = Jelly::query('category')->select_column(array('name', 'id'))->where('id', '=', $material->category->parent_id)->limit(1)->select()?>
<ul class="breadcrumb">
    <li><a href="/">Главная</a> <span class="divider">/</span></li>
    <li><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $parent->id()))?>"><?=$parent->name?></a> <span class="divider">/</span></li>
    <li><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $material->category->id()))?>"><?=$material->category->name?></a> <span class="divider">/</span></li>
    <li class="active"><?=$material->title?></li>
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
<?$user = A2::instance()->get_user();?>
<div class="span8">
    <div class="player">
        <div id="player"></div>
    </div>
    <div class="views-info">
        <div class="video-extras-likes-dislikes pull-left">
            <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span><?=$mpoll['like']?></span></div>
            <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span><?=$mpoll['dislike']?></span></div>
        </div>
        <div class="buttons pull-right">
            <a href="<?=Route::url('vote', array('act' => 'like', 'type' => $material->get_resource_id(), 'id' => $material->id()))?>" class="btn btn-mini btn-success<?=(sizeof($material_user_vote) AND ($material_user_vote->value == TRUE)) ? ' disabled':''?>" type="button"><i class="icon icon-thumbs-up icon-white"></i>Нравится</a>
            <a href="<?=Route::url('vote', array('act' => 'dislike', 'type' => $material->get_resource_id(), 'id' => $material->id()))?>" class="btn btn-mini btn-warning<?=(sizeof($material_user_vote) AND ($material_user_vote->value == FALSE)) ? ' disabled':''?>" type="button"><i class="icon icon-thumbs-down icon-white"></i>Не нравится</a>
        </div>
        <div class="video-extras-sparkbars">
            <?$total = $mpoll['like'] + $mpoll['dislike']?>
            <div class="video-extras-sparkbar-likes" style="width: <?=$mpoll['like'] * 100 / $total?>%"></div>
            <div class="video-extras-sparkbar-dislikes" style="width: <?=$mpoll['dislike'] * 100 / $total?>%;"></div>
        </div>
    </div>

    <div class="user_header">
        <div class="pull-left">
            <i class="icon-user"></i>
            <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $material->user->id()))?>"><?=$material->user->firstname?></a>
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
    if($user AND $user->is_admin()) $admin = TRUE;?>
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

                $('a.disabled').bind('click', function(e){
                    e.preventDefault();
                });
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
                        <?=($c->user->email?'<a class="cmnt_author" href="'.Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $c->user->id)).'"><strong>'.$c->user->firstname.'</strong></a>': '<span class="cmnt_author"><strong>'.$c->guest_name.'</strong></span>')?>
                        <small class="pull-right"><?=date('d.m.y', $c->date)?></small>
                    </div>
                    <div class="msg_txt">
                        <?=$c->text?>
                    </div>
                    <div class="msg_footer">
                        <a class="answer pull-left" href="#">Ответить</a>
                        <div class="buttons pull-right">
                            <?=($admin?'<a href="'.Route::url('default', array('controller' => 'comment', 'action' => 'delete', 'id' => $c->id)).'" class="btn btn-mini btn-danger"><i class="icon icon-remove icon-white"></i>'.__('global.delete').'</a>':'')?>
                            <a href="<?=Route::url('vote', array('act' => 'like', 'type' => $c->get_resource_id(), 'id' => $c->id()))?>" class="btn btn-mini btn-success<?=($comments_user_vote[$c->id()]['like']) ? ' disabled' : ''?>">
                                <i class="icon icon-thumbs-up icon-white"></i><?=($cpoll[$c->id()]['like'] ? $cpoll[$c->id()]['like']:'0')?>
                            </a>
                            <a href="<?=Route::url('vote', array('act' => 'dislike', 'type' => $c->get_resource_id(), 'id' => $c->id()))?>" class="btn btn-mini btn-warning<?=($comments_user_vote[$c->id()]['dislike']) ? ' disabled' : ''?>">
                                <i class="icon icon-thumbs-up icon-white"></i><?=($cpoll[$c->id()]['dislike']?$cpoll[$c->id()]['dislike']:0)?>
                            </a>
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
    <?foreach ($similar['similar'] as $s):?>
        <div class="media">
            <a class="pull-left thumbnail" href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $s->id()))?>">
                <img class="media-object" src="/<?=$s->thumb()?>" width="120">
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'show', 'id' => $s->id()))?>"><?=Text::limit_words($s->title, 6)?></a></h4>
                <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $s->user->id()))?>"><small><?=$s->user->firstname?></small></a>
            </div>
            <div class="video-extras-likes-dislikes pull-left">
                <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span><?=$similar['votes'][$s->id()]['like'] ? $similar['votes'][$s->id()]['like'] : 0?></span></div>
                <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span><?=$similar['votes'][$s->id()]['dislike'] ? $similar['votes'][$s->id()]['dislike'] : 0?></span></div>
            </div>
        </div><!-- /media -->
    <?endforeach;?>
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