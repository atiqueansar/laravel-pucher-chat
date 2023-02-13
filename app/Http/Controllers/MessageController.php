<?php

namespace App\Http\Controllers;

use App\Helpers\FakerURL;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller {

    public function index(){
        $users = User::where('id','!=',auth()->id())->get();
        return view('message.index', compact('users'));
    }

    public function getMessage($receiverId) {
        Message::where([
            ['sender_id','=',FakerURL::id_d($receiverId)],
            ['receiver_id','=',auth()->id()],
            ['seen','=',0]
        ])->update(['seen'=>1]);

        $receiverName = User::findOrFail(FakerURL::id_d($receiverId))->name;

        $messages = Message::where([
            ['sender_id','=',FakerURL::id_d($receiverId)],
            ['receiver_id','=',auth()->id()]
        ])->orWhere([
            ['receiver_id','=',FakerURL::id_d($receiverId)],
            ['sender_id','=',auth()->id()]
        ])->get();

        return view('message.partials.messages', compact('messages','receiverName','receiverId'))->render();
    }

    public function sendMessage($receiverId) {
        $messageLimit = config('services.package.'.auth()->user()->package);
        $messageCount = Message::where([
            ['sender_id',auth()->id()],
            ['receiver_id',FakerURL::id_d($receiverId)],
            ['created_at','>=',date('Y-m-01 00:00:00')],
            ['created_at','<=',date('Y-m-t 23:59:59')],
        ])->count();
        if ($messageCount < $messageLimit) {
            $request = request()->all();
            $request['receiver_id'] = FakerURL::id_d($receiverId);
            $request['sender_id'] = auth()->id();
            $message = Message::create($request);
            if (!empty($message)) {
                fireDoctorMessage($message);
                return response()->json(['status'=>'success'],200);
            } else {
                return response()->json(['status'=>'error','msg' => 'Message has not been sent.'],200);
            }
        } else {
            return response()->json(['status'=>'warning','msg' => "Your $messageLimit messages limit has been completed, please upgrade your package"],200);
        }
    }

}
