<?php

namespace App\Models;
class Message extends CoreModel {
    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'seen'
    ];

}
