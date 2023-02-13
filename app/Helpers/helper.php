<?php
use Illuminate\Support\Facades\Request;
use Pusher\Pusher;

if (!function_exists("urlSegment")) {
    function urlSegment($segment){
        return Request::segment($segment);
    }
}

if (!function_exists('fireDoctorMessage')){
    function fireDoctorMessage($message){
        $options = array(
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'useTLS' => true
        );
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            $options
        );
        $message->only_time = date('h:i A', strtotime($message->created_at));
        $pusher->trigger('receiver-channel', 'receiver-event', json_encode($message));
    }
}
