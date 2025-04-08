<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['file_path', 'description'];

    public function attachable()
    {
        return $this->morphTo();
    }
}
