<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/chat.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container app">
    <div class="row app-one">
        <div class="col-sm-4 side">
            <div class="side-one">
                <div class="row heading">
                    <div class="col-sm-3 col-xs-3 heading-avatar">
                        <div class="heading-avatar-icon">
                            <img src="/default.png">
                            <span class="ml-1">{{auth()->user()->name}}</span>
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9">
                        <a class="pull-right" href="{{route('logout')}}" title="Logout">
                            <i class="fa fa-2x fa-sign-out"></i>
                        </a>
                    </div>
                </div>
                <div class="row searchBox">
                    <div class="col-sm-12 searchBox-inner">
                        <div class="form-group has-feedback">
                            <input id="searchText" type="text" class="form-control" name="searchText"
                                   placeholder="Search">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="row sideBar">
                    @include('message.partials.chatter',[$users])
                </div>
            </div>
        </div>
        <div class="col-sm-8 conversation"></div>
    </div>
</div>

<script src="{{asset('/')}}assets/js/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript">
    Pusher.logToConsole = true;
    var pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('receiver-channel');
    channel.bind('receiver-event', function(data) {
        data = JSON.parse(data);
        $(`.chatter--innernotify${data.sender_id}`).css("display", "flex");
        $(`.chatter--innernotify${data.sender_id} p`).text(parseFloat($(`.chatter--innernotify${data.sender_id} p`).text()) + parseFloat(1));
        if ($(`.data--chatting-open${data.sender_id}`).html() && $(`.data--chatting-open${data.sender_id}`).html() !== undefined) {
            let newMes = `
                <div class="row message-body">
                    <div class="col-sm-12 message-main-receiver">
                        <div class="receiver">
                            <div class="message-text">
                                ${data.message}
                            </div>
                            <span class="message-time pull-right">${data.only_time}</span>
                        </div>
                    </div>
                </div>
            `;
            $('.message#conversation').append(newMes);
            setTimeout(function(){
                var objDiv = document.getElementById("conversation");
                objDiv.scrollTop = objDiv.scrollHeight;
            }, 600);
        }
    });

    $(function () {
        $(".heading-compose").click(function () {
            $(".side-two").css({
                "left": "0"
            });
        });

        $(".newMessage-back").click(function () {
            $(".side-two").css({
                "left": "-100%"
            });
        });
    });

    function showMessage(input,id) {
        receiverId = id;
        $('.conversation').html('<div id="overlay"><img class="meimg" src="{{asset('/')}}assets/img/loader.gif" /></div>');
        document.getElementById("overlay").style.display = "block";
        $('#scroll--chat').find('.chat').removeClass('active');
        $(input).addClass('active');

        $(input).find('.chatter--innernotify').css("display", "none");
        $(input).find('.chatter--innernotify').children().text("0");

        axios.get(receiverId).then(function (res) {
            document.getElementById("overlay").style.display = "none";
            $('.conversation').append(res.data);
            setTimeout(function(){
                var objDiv = document.getElementById("conversation");
                objDiv.scrollTop = objDiv.scrollHeight;
            }, 600);
        });
        return false;
    }

    function sendMessage(data) {
        setTimeout(function(){
            var objDiv = document.getElementById("conversation");
            objDiv.scrollTop = objDiv.scrollHeight;
        }, 600);
        axios.post($('#send').val(), {message:data}).then(function (response){
            console.log('response.data.status',response.data.status)
            if(response.data.status == 'warning'){
                alert(response.data.msg);
            } else if (response.data.status == 'success') {
                let newMes = `
                <div class="row message-body">
                    <div class="col-sm-12 message-main-sender">
                        <div class="sender">
                            <div class="message-text">
                                ${data}
                            </div>
                            <span class="message-time pull-right">${new Date().toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })}</span>
                        </div>
                    </div>
                </div>
            `;
                $('.message#conversation').append(newMes);
            }
        });
        return;
    }
</script>
</body>
</html>
