<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    public function order(){
        return $this->belongsTo('App\Models\Order');
      }
      public function seller(){
        return $this->belongsTo('App\Models\User','seller_id');
      }
      public function buyer(){
        return $this->belongsTo('App\Models\User','buyer_id');
      }
      public function replies(){
        return $this->hasMany('App\Models\DisputeReply');
      }
}
