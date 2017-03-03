<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    protected $table = 'device_types';
    protected $primaryKey = 'id';

    /**
     * RELATIONSHIP
     * Get devices of this type
     */
    public function devices()
    {
        return $this->hasMany('App\Device', 'device_id', 'id');
    }
}
