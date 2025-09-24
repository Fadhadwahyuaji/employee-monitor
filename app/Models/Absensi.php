<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['user_id', 'check_in', 'check_out', 'photo_path', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}