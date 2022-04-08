<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    public function category() {
        return $this->belongsTo('App\Models\NewsCategory');
      }

      public function user() {
        return $this->belongsTo('App\Models\User');
      }


      public function scopeWhereLike($query, $column, $value) {
       return $query->where($column, 'like', '%'.$value.'%');
      }

      public function scopeOrWhereLike($query, $column, $value ){
       return $query->orWhere($column, 'like', '%'.$value.'%');
      }
}