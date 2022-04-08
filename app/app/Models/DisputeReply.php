<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputeReply extends Model
{
    public function dispute(){
        return $this->belongsTo('App\Models\Dispute');
      }
      public function user(){
          return $this->belongsTo('App\Models\User');
      }
}
