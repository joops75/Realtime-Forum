<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reply extends Model
{
    public function user() {
        $this->belongsTo(User::class);
    }
    
    public function question() {
        $this->belongsTo(Question::class);
    }
    
    public function like() {
        $this->hasMany(Like::class);
    }
}
