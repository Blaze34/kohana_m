(function($){

	// create global app parameters...
	var contacts = {},

        tabs = null,
        jspT = null,
        jspM = null,
        messages = null,

        receiver_id = null,

		tmplt = {
            chat: [
                '<ul id="message_list_${id}" class="unstyled messages_wrap" data-id="${id}">',
                    '<li class="history">',
                        '<div class="controls-row">',
                            '<div class="span4 muted">Просмотреть историю за:</div>',
                            '<ul class="span8 nav nav-pills">',
                                '<li class="skip_search"><a data-period="day" href="#">день</a></li>',
                                '<li class="skip_search"><a data-period="month" href="#">месяц</a></li>',
                                '<li class="skip_search"><a data-period="year" href="#">год</a></li>',
                                '<li class="skip_search"><a data-period="all" href="#">все время</a></li>',
                            '</ul>',
                        '</div>',
                    '</li>',
                '</ul>'].join(""),
            tab: [
				'<li data-id="${id}">',
                    '<a href="#message_list_${id}" class="controls-row">',
                        '<span class="login span9">${username}</span>',
                        '<span class="new_message span2">',
                            '<i class="icon-envelope"></i>',
                            '<strong class="msg_counter">${count}</strong>',
                        '</span>',
                        '<span class="span1">',
                            '<button class="close" type="button">×</button>',
                        '</span>',
                    '</a>',
                '</li>'
			].join(""),
			message: [
                '<li>',
                    '<span class="pull-right muted">${time}</span>',
                    '<strong>${sender}:</strong> {{html text}}',
                '</li>'
			].join(""),
            info: '<li class="additional_info muted">${text}</li>',
            status: '<li class="additional_info muted"><strong>${username}</strong> ${text}</li>'
		};

    WS.getUserName = function(user, forTab){
        var username = '';
        if (forTab){
            username = $.trim([user.lastname, user.firstname].join(' '));
            if ( ! username.length)
                username = user.username;

            if (user.city)
                username += ' ('+user.city+')';
        }else{
            username = $.trim([user.firstname, user.lastname].join(' '));

            if ( ! username.length)
                username = user.username;
        }

        return username
    };

    WS.insertMessage = function(rid, user, message, isMe, time, isNew, ignoreSort){

        if (rid){

            if ( ! existContact(rid)) addChat(rid, user, true);

            var c = contacts[rid];
            var $html = $.tmpl(tmplt.message, {
                sender: WS.getUserName(user),
                text: WS.msgHtml(message),
                time: time ? WS.getTime(time) : WS.getTime()
            });

            if(isMe) $html.addClass('marker');

            if(isNew) {
                $html.addClass('alert alert-info');
                WS.incMsgCounter(c.tab);
            }

            $html.appendTo(c.chat);
            if (rid == receiver_id){
                jspM.reinitialise();
                jspM.scrollToPercentY(100)
            }

            if (!ignoreSort){
                sortTabs();
            }
        }
    };

    WS.unreadMessageList = function(data){
        $.each(data, function(k, m){
            WS.insertMessage(m.user.id, m.user, m.message, false, m.time, true, true);
        });
        sortTabs();
    };

    WS.unreadMessageLeft = function(){};

    function searchReset(){
        if (typeof search == 'object' && typeof search.reset == 'function'){
            search.reset()
        }
    }

	// bind DOM elements like button clicks and keydown
	function bindDOMEvents(){
        tabs.on('click', 'a', function (e) {
            e.preventDefault();
            var $$ = $(this);
            var id = $$.parent().data('id');
            if (id && existContact(id)){
                receiver_id = id;
                searchReset();
                $$.tab('show');
                messages.find('.default_text').hide();
                jspM.reinitialise();
            }
        });

        tabs.on('click', '.close', function (e) {
            e.preventDefault();
            var $$ = $(this);
            var id = $$.parents('li:first').data('id');

            if (id && existContact(id)){
                if (receiver_id == id){
                    receiver_id = null;
                    messages.find('.default_text').show();
                }

                var c = contacts[id];
                searchReset();
                c.tab.remove();
                c.chat.remove();
                delete contacts[id];
                WS.emit('close_tab', id );
            }
        });

        messages.on('click', '.history a', function (e) {
            e.preventDefault();
            var $$ = $(this);
            if ( ! $$.parent().hasClass('active')){
                $$.tab('show');

                if ($$.data('period')){
                    getHistory($$.data('period'))
                }
            }
        });

        messages.on('click', function (e) {
            if (receiver_id){
                read(receiver_id)
            }
            console.log('click')
        });

		$('#input_message').on({
            keydown: function(e){
                var key = e.which || e.keyCode;
                if(e.ctrlKey && key == 13) handleMessage()
            },
            click: function(e){
                if (receiver_id)
                    read(receiver_id)
            }
        });

        $('#send_message').on('click', function(){
            handleMessage();
        });
	}

    function sortTabs(){
        var r = false;
        $('li', tabs).each(function(k, v){
            var $$ = $(this);
            var hold = $$.find('.msg_counter');
            if (hold.length){
                var count = parseInt(hold.text()) || 0;
                if (count > 0){
                    if (r) $$.prependTo(tabs);
                }else{
                    r = true;
                }
            }
        })
    }

	function bindSocketEvents(){

		WS.bind('ready', function(data){
			$('#chat').find('.shadow').animate({ opacity: 0 }, 200, function(){
				$(this).hide();
				$('#chat').find('input[name=message]').focus();
			});
		});

        WS.bind('contact_list', function(data){
            $.each(data, function(k, u){
                if ( ! existContact(u.id)){
                    addChat(u.id, u, u.online)
                }
            })
        });

        WS.bind('history', function(data){
            showHistory(data.id, data.messages);
        });

		WS.bind('error', function(data){
            shadowInfo((data.type ? data.type + ' ' : '') + (data.msg ? data.msg : 'Во время подключения произошла ошибка. Повторите попытку позже'));
		});

		WS.bind('presence', function(data){
            if (existContact(data.user.id)){
                setStatus(data.user, data.state == 'online');
            }
		});
	}

    function setStatus(user, online){
        var c = contacts[user.id];
        var l = c.tab.find('.login');

        if (online){
            l.addClass('online');
        }else{
            l.removeClass('online');
        }
    }

    function getHistory(period){
        WS.emit('history', {period: period, user_id: receiver_id});
    }

    function read(id){
        if (existContact(id)){
            var c = contacts[id];

            c.tab.find('.new_message strong').text('');

            var newMessages = c.chat.find('.alert-info');

            if (newMessages.length){
                WS.emit('read_chat', id);

                newMessages.removeClass('alert alert-info');

                jspM.reinitialise();
            }
            sortTabs();
        }
    }

    function existContact(id){
        return id in contacts;
    }

    function defTab(){
        if ( ! window.location.hash)
            return null;
        var id,
            hash = window.location.hash;

        if (hash.indexOf('#view_') == 0){
            hash = hash.substr(6);
            id = parseInt(hash)
        }

        return id
    }

    function addChat(id, user, online){
        var tab = $.tmpl(tmplt.tab, {
            id: id,
            username: WS.getUserName(user, true)
        });
        var chat = $.tmpl(tmplt.chat, { id: id });
        if (online)
            tab.find('.login').addClass('online');

        contacts[id] = {tab: tab, chat: chat};

        tab.appendTo(tabs);
        chat.prependTo(messages);

        jspT.reinitialise();

        var def = defTab();
        if(def && id == def){
            tab.find('a').click()
        }
    }

	function handleMessage(){
        var inp = $('#input_message');
		var message = $.trim(inp.val());

		if(receiver_id && message){
			WS.emit('chat_message', { message: message, receiver_id: receiver_id });

			WS.insertMessage(receiver_id, {username: WS.nick()}, message, true);
			inp.val('');
		}
	}

    function showHistory(id, msgList){
        searchReset();
        if (existContact(id)){
            var c = contacts[id];
            var lastDate = null;
            c.chat.children('li:not(.history)').remove();

            $.each(msgList, function(k, m){
                var date = new Date(m.time);

                var curDate = WS.addZero(date.getDate()) + '.' + WS.addZero(date.getMonth() + 1) + '.' + date.getFullYear();

                var $html = $.tmpl(tmplt.message, {
                    sender: WS.getUserName(m.user),
                    text: WS.msgHtml(m.message),
                    time: WS.addZero(date.getHours()) + ':' + WS.addZero(date.getMinutes())
                });

                if (lastDate === null || curDate != lastDate){
                    lastDate = curDate;
                    $.tmpl(tmplt.info, { text: curDate }).appendTo(c.chat);
                }

                $html.appendTo(c.chat);
            });

            jspM.reinitialise();
//            jspM.scrollToPercentY(100);
        }
    }

    function shadowInfo(html){
        $('#chat').find('.shadow .info').html(html);
    }

	// on document ready, bind the DOM elements to events
	$(function(){
        tabs = $('#chat-list');
        messages = $('#chat-messages');
        var tabsWrap = $('#chat-list-wrapper');
        var messageWrap = $('#chat-messages-wrapper');

        var jspOpt = {
            stickToBottom: true,
            verticalGutter: -16,
            contentWidth: 590
        };

        messageWrap.jScrollPane(jspOpt);
        jspM = messageWrap.data('jsp');

        jspOpt.contentWidth = 150;

        tabsWrap.jScrollPane(jspOpt);
        jspT = tabsWrap.data('jsp');

        search.onShow = function(){
            if (search.current()){
                var el = $(search.current());
                var pos = el.position();

                jspM.scrollToY(pos.top)
            }
        };

		bindDOMEvents();
        bindSocketEvents();
	});

})(jQuery);