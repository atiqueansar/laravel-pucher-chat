@foreach($users as $user)
    <div onclick="showMessage(this,'{{route('get-messages',$user->faker_id)}}');" class="row sideBar-body">
        <div class="col-sm-3 col-xs-3 sideBar-avatar">
            <div class="avatar-icon">
                <img src="/default.png">
            </div>
        </div>
        <div class="col-sm-9 col-xs-9 sideBar-main">
            <div class="row">
                <div class="col-sm-8 col-xs-8 sideBar-name">
                    <span class="name-meta">{{$user->name}}</span>
                </div>
                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                    <div class="align-items-center justify-content-center bg-danger pull-right rounded-circle chatter--innernotify chatter--innernotify{{$user->id}}" style="width: 22px; height: 22px;display: {{($user->un_seen_messages_count!=0) ? 'flex' : 'none'}};">
                        <p class="mb-0 s-10 text-dark fw-500">
                            {{($user->un_seen_messages_count!=0) ? $user->un_seen_messages_count : '0'}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
