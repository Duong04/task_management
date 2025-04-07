<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';
    protected $fillable = [
        'user_id',
        'position_id',
        'employee_code',
        'phone',
        'address',
        'dob',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function position() {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
