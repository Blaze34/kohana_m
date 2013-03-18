(function($){

    if (window.location.hash){
        if (window.location.hash.indexOf('#view_') == 0){
            window.location.hash = '';
        }
    }

	var jspM = null,
        messages = null,
        admStatus = 'offline',
        timeoutID = null,

		tmplt = {
			message: [
                '<li>',
                    '<span class="pull-right muted">${time}</span>',
                    '<strong>${sender}:</strong> {{html text}}',
                '</li>'
			].join(""),
            info: '<li class="additional_info muted">${text}</li>',
            status: '<li class="additional_info muted"><strong>${username}</strong> ${text}</li>'
		};
    WS.insertMessage = function(id, user, message, isMe, time, isNew){
        var chat = getChat();
        if (chat){
            var $html = $.tmpl(tmplt.message, {
                sender: WS.getUserName(user),
                text: WS.msgHtml(message),
                time: time ? WS.getTime(time) : WS.getTime()
            });

            if(isMe){
                $html.addClass('marker')
            }

            if(isNew) {
                $html.addClass('alert alert-info');
            }

            $html.appendTo(chat);

            jspM.reinitialise();
            jspM.scrollToPercentY(100)
        }
    };

    WS.unreadMessageList = function(data){
        $.each(data, function(k, m){
            WS.insertMessage(null, m.user, m.message, false, m.time, true);
        })
    };

    WS.unreadMessageLeft = function(){};

    function searchReset(){
        if (typeof search == 'object' && typeof search.reset == 'function'){
            search.reset()
        }
    }

	// bind DOM elements like button clicks and keydown
	function bindDOMEvents(){
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
            read()
        });

		$('#input_message').on({
            keydown: function(e){
                var key = e.which || e.keyCode;
                if(e.ctrlKey && key == 13) handleMessage()
            },
            click: function(e){
                read()
            }
        });

        $('#send_message').on('click', function(){
            handleMessage();
        });
	}

	function bindSocketEvents(){
		WS.bind('ready', function(){
			$('#chat').find('.shadow').animate({ opacity: 0 }, 200, function(){
				$(this).hide();
				$('#chat').find('input[name=message]').focus();
			});
		});

        WS.bind('history', function(data){
            showHistory(data.messages);
        });

		WS.bind('error', function(data){
            shadowInfo((data.type ? data.type + ' ' : '') + (data.msg ? data.msg : 'Во время подключения произошла ошибка. Повторите попытку позже'));
		});

		WS.bind('presence', function(data){
            admStatus = data.state;

            if (timeoutID)
                clearInterval(timeoutID);

            timeoutID = setTimeout(setStatus, 3000);
		});
	}

    function getChat(){
        return messages.children('ul');
    }

    function setStatus(){
        var st = $('#admin_status');

        st.show();
        st.find('span').text(admStatus).css('color', admStatus == 'online' ? 'green' : 'grey');
    }

    function getHistory(period){
        WS.emit('history', {period: period});
    }

    function read(){
        var chat = getChat();

        var newMessages = chat.find('.alert-info');

        if (newMessages.length){
            WS.emit('read_chat');

            newMessages.removeClass('alert alert-info');

            jspM.reinitialise();
        }
    }

    function handleMessage(){
        var inp = $('#input_message');
		var msg = $.trim(inp.val());

		if(msg){
			WS.emit('chat_message', { message: msg });

            WS.insertMessage(null, {username: WS.nick()}, msg, true);
			inp.val('');
		}
	}

    function showHistory(msgList){
        searchReset();
        var chat = getChat();
        if (chat){
            var lastDate = null;
            chat.children('li:not(.history)').remove();

            $.each(msgList, function(k, m){
                var date = new Date(m.time);

                var curDate = WS.addZero(date.getDate()) + '.' + WS.addZero(date.getMonth() + 1) + '.' + date.getFullYear();

                var $html = $.tmpl(tmplt.message, {
                    sender: m.user.username,
                    text: WS.msgHtml(m.message),
                    time: WS.addZero(date.getHours()) + ':' + WS.addZero(date.getMinutes())
                });

                if (lastDate === null || curDate != lastDate){
                    lastDate = curDate;
                    $.tmpl(tmplt.info, { text: curDate }).appendTo(chat);
                }

                $html.appendTo(chat);
            });

            jspM.reinitialise();
            jspM.scrollToPercentY(100);
        }
    }

    function shadowInfo(html){
        $('#chat').find('.shadow .info').html(html);
    }

	// on document ready, bind the DOM elements to events
	$(function(){
        messages = $('#chat-messages');
        var messageWrap = $('#chat-messages-wrapper');

        var jspOpt = {
            stickToBottom: true,
            verticalGutter: -16,
            contentWidth: 650
        };

        messageWrap.jScrollPane(jspOpt);
        jspM = messageWrap.data('jsp');

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