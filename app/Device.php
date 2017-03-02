<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';
    protected $primaryKey = 'id';

    /**
     * RELATIONSHIP
     * Get device messages
     */
    public function messages()
    {
        return $this->hasMany('App\Message', 'device_id', 'id');
    }
}
