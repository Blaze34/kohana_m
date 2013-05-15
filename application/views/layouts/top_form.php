<script type="text/javascript">
    $(document).ready(function(){
        $('#main_tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');

        });

        $('.search_on_tags').click(function () {
            var tags = $('.search-query').tagit('tags'),
                arr = tags.map(function(i) {return i['value'];}),
                query = $.param({q: arr});
            window.location = '<?=Route::url('default', array('controller' => 'tag', 'action' => 'show'))?>' + '?' + query;
        });

        var cache = {};
        var autocomplete_tags = function( request, response ) {
            if (request.term in cache){
                response(cache[request.term]);
            } else {
                $.post("<?=Route::url('default', array('controller' => 'tag', 'action' => 'get'))?>", {term: request.term}, function(data){
                    cache[request.term] = data;
                    response(data);
                }, "json");
            }
        };

        // Initialize tagit plugin

        $('.search-query').tagit({tagSource: autocomplete_tags, minLength: 1, allowNewTags: true, maxTags: 8});

        $('.main_tabs input[type="radio"]').change(function(){
            var tags = $('.search-tags'),
                words = $('.search-words');

            if($(this).val() == 'by-tags'){
                tags.show();
                words.hide();
            }
            else if($(this).val() == 'by-words'){
                tags.hide();
                words.show();
            }
         });

    });
</script>

<div class="main_tabs">
    <ul class="nav nav-tabs pull-left" id="main_tabs">
        <li class="active"><a href="#find_video"><i class="bt_icon icon-search"></i>Искать видео</a></li>
        <li class=""><a href="#cat_video"><i class="bt_icon icon-film"></i>Нарезать видео</a></li>
    </ul>
    <a class="btn btn-file pull-right" href="<?=Route::url('default', array('controller' => 'material', 'action' => 'add_gif'))?>"><i class="icon-picture"></i> Добавить гиф</a>
    <div class="clearfix"></div>
    <div class="tab-content">
        <div class="tab-pane active" id="find_video">
            <div class="form-search">
                <div class="input-append search-tags">
                    <ul class="search-query"></ul>
                    <button type="submit" class="btn btn-large search_on_tags">Искать</button>
                </div>
                <div class="input-append search-words">
                    <form action="<?=Route::url('default', array('controller' => 'index', 'action' => 'search'))?>" method="post">
                        <input type="text" name="words" class="span2 search-query" />
                        <button type="submit" class="btn btn-large ">Искать</button>
                    </form>
                </div>
                <div class="input-append radio-row">
                    <label class="radio">
                        <input type="radio" name="search" value="by-tags" checked>
                        По тегам
                    </label>
                    <label class="radio">
                        <input type="radio" name="search" value="by-words">
                        По словам
                    </label>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="cat_video">
            <form class="form-search" method="post" action="<?=Route::url('default', array('controller' => 'material', 'action' => 'parse'))?>">
                <div class="input-append">
                    <input type="text" class="span2 search-query" name="url" placeholder="Например: http://www.youtube.com/watch?v=RmaHGY7BEog">
                    <button type="submit" class="btn btn-large">Нарезать</button>
                </div>
            </form>
        </div>
    </div>
</div>
