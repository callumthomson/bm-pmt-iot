<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $fillable = ['body', 'created_at'];

    protected $touches = ['device'];

    /**
     * RELATIONSHIP
     * Get device which sent message
     */
    public function device()
    {
        return $this->belongsTo('App\Device', 'device_id', 'id');
    }

    /**
     * MUTATOR
     * Make setting the updated_at column do nothing because the column doesn't exist
     */
    public function setUpdatedAtAttribute($value)
    {

    }

    /**
     * MUTATOR
     * Get the body array
     */
    public function getBodyAttribute()
    {
        return json_decode($this->attributes['body'], true);
    }
}
