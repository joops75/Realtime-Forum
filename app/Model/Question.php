<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
// don't need to state Reply and Category models here as they are in the same folder as this file

class Question extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function replies() {
        return $this->hasMany(Reply::class);
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getPathAttribute() {
        // function accessed via $this->path
        // asset function appends base url to passed in string
        return asset("api/question/$this->slug");
    }
}
