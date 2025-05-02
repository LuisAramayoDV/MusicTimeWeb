<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reproduction extends Model
{
    use HasFactory;

    protected $fillable = ['song_id', 'user_id', 'created_at'];

    public $timestamps = false;

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
