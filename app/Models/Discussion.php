<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = ['message', 'user_id'];

    public function discussionable()
    {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
