<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'type_id'
    ];
    protected $hidden = [
      'messages'
    ];

    public function __construct(array $attributes = [])
    {
        $this->attributes['token'] = str_random(32);
        parent::__construct($attributes);
    }

    /**
     * RELATIONSHIP
     * Get device messages
     */
    public function messages()
    {
        return $this->hasMany('App\Message', 'device_id', 'id');
    }

    /**
     * RELATIONSHIP
     * Get device type
     */
    public function device_type()
    {
        return $this->hasOne('App\DeviceType', 'id', 'type_id');
    }

    /**
     * GETTER
     * Get the last message transmitted by the device
     *
     * @return Message|null
     */
    public function getLastMessageAttribute()
    {
        $message = Message::where('device_id', '=', $this->attributes['id'])
            ->orderBy('created_at', 'desc')
            ->first();
        if($message) {
            return $message;
        } else {
            $message = new Message;
            $message->created_at = Carbon::now();
        }
    }
}
