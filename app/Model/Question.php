<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
// don't need to state Reply and Category models here as they are in the same folder as this file

class Question extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function replies() {
        return $this->hasMany(Reply::class);
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
