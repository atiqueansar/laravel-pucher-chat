<?php
namespace App\Models;

use App\Helpers\FakerURL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'package'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['faker_id','un_seen_messages_count'];

    public function getFakerIdAttribute()
    {
        return FakerURL::id_e($this->id);
    }

    public function getPatient(){
        return $this->belongsTo(User::class,'patient_id','id');
    }

    public function getUnSeenMessagesCountAttribute(){
        return Message::where('sender_id', $this->id)->where('receiver_id', auth()->id())->where('seen',0)->count();
    }
}
