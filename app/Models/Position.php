<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = [
        'name',
        'description'
    ];

    public function users() {
        return $this->hasMany(UserDetail::class, 'position_id');
    }
}
