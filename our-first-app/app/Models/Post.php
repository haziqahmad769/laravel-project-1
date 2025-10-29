<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    public function user()
    {
        // (a = class that has relationship with,b = column that powering the relationship )
        return $this->belongsTo(User::class, 'user_id');
    }
}
