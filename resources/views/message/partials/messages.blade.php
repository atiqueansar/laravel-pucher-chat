<div class="heading">
    <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
        <div class="heading-avatar-icon">
            <img src="/default.png">
        </div>
    </div>
    <div class="col-sm-8 col-xs-7 heading-name">
        <a class="heading-name-meta">{{$receiverName}}</a>
        <input type="hidden" id="send" value="{{route('send-message',$receiverId)}}" >
    </div>
</div>
<div class="message data--chatting-open{{\App\Helpers\FakerURL::id_d($receiverId)}}" id="conversation">
    @foreach($messages as $message)
        @if($message->sender_id == auth()->id())
            <div class="row message-body">
                <div class="col-sm-12 message-main-sender">
                    <div class="sender">
                        <div class="message-text">
                            {{$message->message}}
                        </div>
                        <span class="message-time pull-right">{{date('h:i A', strtotime($message->created_at))}}</span>
                    </div>
                </div>
            </div>
        @else
            <div class="row message-body">
                <div class="col-sm-12 message-main-receiver">
                    <div class="receiver">
                        <div class="message-text">
                            {{$message->message}}
                        </div>
                        <span class="message-time pull-right">{{date('h:i A', strtotime($message->created_at))}}</span>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
<div class="reply">
    <div class="col-sm-11 col-xs-11 reply-main">
        <input name="chat_message" class="form-control" id="chat_message">
    </div>
    <div id="send_message" class="col-sm-1 col-xs-1 reply-send">
        <i class="fa fa-send fa-2x" aria-hidden="true"></i>
    </div>
</div>

<script>
    $(function (){
        $('#chat_message').on('keyup', function (e) {
            if (e.key === 'Enter') {
                if (e.target.value.trim()) {
                    sendMessage(e.target.value.trim());
                    e.target.value='';
                }
            }
            return false;
        });
        $('#send_message').on('click', function (e) {
            if ($('#chat_message').val().trim()) {
                sendMessage($('#chat_message').val().trim());
                $('#chat_message').val('');
            }
            return false;
        });
    });
</script>
