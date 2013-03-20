window.WS = {};

function nl2br (str) {
    return str.replace(/\n/g, '<br>').replace(/\r/g, '');
}

function makeLinks(text){
    return text
        .replace(/(https\:\/\/|http:\/\/)([www\.]?)([^\s|<]+)/gi,'<a href="$1$2$3" target="_blank">$1$2$3</a>')
        .replace(/([^https\:\/\/]|[^http:\/\/]|^)(www)\.([^\s|<]+)/gi,'$1<a href="http://$2.$3" target="_blank">$2.$3</a>');
}

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$(function(){
    $('[rel=tooltip]').tooltip();

    $('.datepicker').datepicker({ language: 'ru' });

    $('body').on('click', '[data-event="dismiss"]', function(e){
        e.preventDefault();
        var $$ = $(this),
            selector = $$.data('target'),
            $parent;

        $parent = $$.parents(selector).eq(0);

        if ($parent.length){
            $parent.remove()
        }
    });

    window.simpleMessage = function(type, message){
        noty({ text: message, type: type, layout: 'center', closeWith: ['click'] })
    }

    var lastConfirmNoty;

    $('body').on('click', '[data-action=confirm]', function(e){
        var $this = $(this),
            href = $this.attr('href') || $this.data('href'),
            text = $this.data('text') || 'Вы действительно хотите это сделать?',
            yes = $this.data('yes') || 'Да',
            no = $this.data('no') || 'Нет';

        var cb;

        if (href && href.indexOf('javascript:') != 0)
        {
            cb = function(){ document.location = href }
        }
        else
        {
            if ( ! $this.data('allow'))
                cb = function(){ $this.data('allow', 1).click() }
        }

        if (cb){

            e.preventDefault();
            e.stopPropagation();

            if (lastConfirmNoty && !lastConfirmNoty.closed){
                lastConfirmNoty.close()
            }

            lastConfirmNoty = noty({
                text: text,
                type: 'confirm',
                dismissQueue: true,
                layout: 'center',
                buttons: [
                    { addClass: 'btn btn-primary', text: yes, onClick: function($noty) { $noty.close(); cb() }},
                    { addClass: 'btn btn-danger', text: no, onClick: function($noty) { $noty.close() }}
                ]
            });
        }
    });

    $('#main_tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('.bxslider > ul').bxSlider({
        minSlides: 5,
        maxSlides: 5,
        slideWidth: 180,
        infiniteLoop: true,
        hideControlOnEnd: false,
        pager: false,
        autoHover: true,
    });
})