<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->hasMany('App\Like')->where('like', '=', '1');

    }

    public function dislikes(){
        return $this->hasMany('App\Like')->where('like', '=', '0');

    }
}
