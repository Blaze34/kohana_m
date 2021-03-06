<script type="text/javascript">
    swfobject.embedSWF("/web/swf/player.swf", "player", "650", "440", "9.0.0", "/web/swf/expressInstall.swf", {begin: '<?=$material->start?>', end: '<?=$material->end?>', vid: '<?=$material->video?>'}, {'allowFullScreen': true});
    $(function(){
        $('a.disabled').bind('click', function(e){
            e.preventDefault();
        });
    });
</script>
<div class="sections">
    <ul class="breadcrumb">
        <li><a href="/">Главная</a> <span class="divider">/</span></li>
        <li><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $categories[0]['id']))?>"><?=$categories[0]['title']?></a> <span class="divider">/</span></li>
        <li class="active"><?=$material->title?></li>
    </ul>

    <?if(sizeof($material->categories) > 1):?>
    <div class="also_refer">
        <h5>Также относится к:</h5>
        <ul class="subcategories">
            <?foreach ($material->categories as $k => $c):?>
                <?if($k != 0):?>
                    <li><a href="<?=Route::url('default', array('controller' => 'category', 'action' => 'show', 'id' => $c->id()))?>"><?=$c->title?></a></li>
                <?endif;?>
            <?endforeach;?>
        </ul>
    </div>
    <?endif;?>
</div>

<?$user = A2::instance()->get_user();?>
<?if($user AND $user->is_admin()) $admin = TRUE?>

<div class="row-fluid">
    <div class="item_layout">
        <div class="sections">
            <div class="headline"><h1><?=$material->title?></h1></div>
        </div><!-- /sections -->
        <div class="span8">
            <?if ($user AND $user->is_admin()):?>
                <div class="well well-small">
                    <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'edit', 'id' => $material->id()))?>" class="btn btn-mini btn-warning"><?=__('global.edit')?></a>
                    <a href="javascript:;" data-href="<?=Route::url('default', array('controller' => 'material', 'action' => 'delete', 'id' => $material->id))?>" class="btn btn-mini btn-danger alert_delete"><?=__('global.delete')?></a>
                    <span> - Управление материалом</span>
                </div>
                <div class="clearfix"></div>
            <?endif;?>
            <div class="player">
                <?if($material->video):?>
                    <div id="player"></div>
                <?else:?>
                    <div id="GIF" <?=$lock_gif ? 'oncontextmenu="return false;"' : ''?>>
                        <img src="<?=($material->url_fix || !$material->url  ? '/' : '')?><?=$material->file()?>" alt=""/>
                    </div>
                <?endif;?>
            </div>
            <div class="views-info">
                <div class="video-extras-likes-dislikes pull-left">
                    <div class="likes-count pull-left"><i class="icon icon-thumbs-up"></i><span><?=$mpoll['like']?></span></div>
                    <div class="dislikes-count pull-left"><i class="icon icon-thumbs-down"></i><span><?=$mpoll['dislike']?></span></div>
                    <div class="mviews pull-left"><?=$material->views?> <i class="icon icon-eye-open"></i></div>
                </div>
                <?if ($user AND ($material->user->firstname != $user->firstname)):?>
                <div class="buttons pull-right">
                    <?=$material_user_vote->value?>
                    <a href="<?=Route::url('vote', array('act' => 'like', 'type' => $material->get_resource_id(), 'id' => $material->id()))?>" class="btn btn-mini btn-success<?=($material_user_vote == 'like') ? ' disabled':''?>"><i class="icon icon-thumbs-up icon-white"></i>Нравится</a>
                    <a href="<?=Route::url('vote', array('act' => 'dislike', 'type' => $material->get_resource_id(), 'id' => $material->id()))?>" class="btn btn-mini btn-warning<?=($material_user_vote == 'dislike') ? ' disabled':''?>"><i class="icon icon-thumbs-down icon-white"></i>Не нравится</a>
                </div>
                <?endif;?>
                <div class="video-extras-sparkbars">
                    <?$total = $mpoll['like'] + $mpoll['dislike']?>
                    <div class="video-extras-sparkbar-likes" style="width: <?=$mpoll['like'] * 100 / $total?>%"></div>
                    <div class="video-extras-sparkbar-dislikes" style="width: <?=$mpoll['dislike'] * 100 / $total?>%;"></div>
                </div>
            </div>
            <?if (sizeof($material->tags)):?>
                <ul class="tagit_list">
                    <?foreach ($material->tags as $t):?>
                        <li class="tagit-choice"><a href="<?=Route::url('default', array('controller' => 'tag', 'action' => 'show')).'?q='.urldecode($t->name)?>" ><?=$t->name?></a></li>
                    <?endforeach?>
                </ul>
            <?endif;?>
            <script type="text/javascript">(function() {
                    if (window.pluso && typeof window.pluso.start == "function") return;
                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                    s.src = d.location.protocol  + '//share.pluso.ru/pluso-like.js';
                    var h=d[g]('head')[0] || d[g]('body')[0];
                    h.appendChild(s);
                })();</script>
            <div class="user_header">
                <div class="pull-left">
                    <i class="icon-user"></i>
                    <?if($material->user->firstname):?>
                        <a href="<?=Route::url('default', array('controller' => 'material', 'action' => 'user', 'id' => $material->user->id()))?>"><?=$material->user->firstname?></a>
                    <?else:?>
                        <span>Гость</span>
                    <?endif;?>
                </div>
                <div class="pull-right"><?=date('d.m.y', $material->date)?></div>
            </div>
            <div class="video_desc"><?=$material->description?></div>

            <div class="video_footer">
                <?if($material->video):?>
                    <div class="video_code pull-left">
                        <textarea onclick="this.select();"><object type="application/x-shockwave-flash" data="<?=URL::site('', TRUE)?>web/swf/player.swf" width="650" height="440" id="player" style="visibility: visible;"><param name="allowFullScreen" value="true"><param name="flashvars" value="begin=<?=$material->start?>&end=<?=$material->end?>&vid=<?=$material->video?>"></object></textarea>
                        <div class="help-block">Код видео</div>
                    </div>
                <?endif;?>
                <div class="pluso pull-right" data-options="medium,round,line,horizontal,counter,theme=01" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,yandex,yazakladki" data-background="transparent"></div>
            </div>
            <div class="comments">
                <h4><?=__('comments.title')?></h4>
                <?if(! $lock_guest_cmnt OR ($lock_guest_cmnt AND $user)):?>
                    <form class="form-horizontal" method="post" action="<?=Route::url('cmnt', array('action' => 'add', 'type' => $material->get_resource_id(), 'id' => $material->id()))?>">
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
                <?endif;?>
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
                                    <?=($admin?'<a href="javascript" data-href="'.Route::url('cmnt', array('type' => $material->get_resource_id(), 'action' => 'delete', 'id' => $c->id)).'" class="btn btn-mini btn-danger alert_delete"><i class="icon icon-remove icon-white"></i>'.__('global.delete').'</a>':'')?>
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