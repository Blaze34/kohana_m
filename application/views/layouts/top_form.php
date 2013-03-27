<script type="text/javascript">
    $(document).ready(function(){
        /*$('.add_gif a').click(function(){
            window.location = "<?=Route::url('default', array('controller' => 'material', 'action' => 'add_gif'))?>"
        })*/

        $('#main_tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');

        });
    })
</script>
<?//$act = Request::initial()->action();?>
<div class="main_tabs">
    <ul class="nav nav-tabs pull-left" id="main_tabs">
        <li class="active"><a href="#find_video"><i class="bt_icon icon-search"></i>Искать видео</a></li>
        <li class=""><a href="#cat_video"><i class="bt_icon icon-film"></i>Нарезать видео</a></li>
    </ul>
    <a class="btn btn-file pull-right" href="<?=Route::url('default', array('controller' => 'material', 'action' => 'add_gif'))?>"><i class="icon-picture"></i> Добавить гиф</a>
    <div class="clearfix"></div>
    <div class="tab-content">
        <div class="tab-pane active" id="find_video">
            <form action="" class="form-search">
                <div class="input-append">
                    <input type="text" class="span2 search-query">
                    <button type="submit" class="btn btn-large">Искать</button>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="cat_video">
            <form class="form-search" action="<?=Route::url('default', array('controller' => 'material', 'action' => 'parse'))?>">
                <div class="input-append">
                    <input type="text" class="span2 search-query" name="url">
                    <button type="submit" class="btn btn-large">Нарезать</button>
                </div>
            </form>
        </div>
<!--        <div class="tab-pane" id="add_gif">-->
            <?/*=Request::factory(Route::url('default', array('controller' => 'material', 'action' => 'add_gif')))->execute()*/?>
<!--        </div>-->
    </div>
</div>