<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';

    /**
     * RELATIONSHIP
     * Get device which sent message
     */
    public function device()
    {
        return $this->belongsTo('App\Device', 'device_id', 'id');
    }
}
