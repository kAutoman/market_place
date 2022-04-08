<?php

namespace App\Models;

use App\Traits\OrderId;
use App\Traits\CalculateTimeDiff;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence; // base trait


class Order extends Model
{
    //
    use Eloquence;
    use SoftDeletes;
    use CalculateTimeDiff;

    use OrderId;
    protected $casts = [
        'token' => 'array',
        'listing_options' => 'array',
        'user_choices' => 'array',
        'customer_details' => 'array',
    ];
	protected $dates = [
        'accepted_at',
        'declined_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $searchableColumns = ['listing.title', 'user.email'];

    protected $searchable = [
        'columns' => [
            'listings.title' => 10,
            'users.name' => 10,
            'users.email' => 10,
        ],
        'joins' => [
            'listings' => ['orders.listing_id','listings.id'],
            'users' => ['orders.user_id','users.id'],
            //'sellers' => ['listings.user_id','listings.id'],
        ],
    ];
    protected $appends = ['hash'];


    public function scopeProcess($query)
    {
    return $query->where('status', '=', "processing");
    }

    public function scopeShipped($query)
    {
    return $query->where('status', '=', "shipped");
    }

    public function scopeAccepted($query)
    {
    return $query->where('status', '=', "accepted");
    }

    public function scopeFinalized($query)
    {
    return $query->where('status', '=', "finalized");
    }

    public function scopeCancelled($query)
    {
    return $query->where('status', '=', "cancelled");
    }

    public function scopeDispute($query)
    {
    return $query->where('status', '=', "disputed");
    }



    public function getHashAttribute($value) {
        return $this->getRouteKey();
    }

    public function dispute() {
      return $this->hasOne('App\Models\Dispute');
    }

    public function listing() {
      return $this->belongsTo('App\Models\Listing')->withTrashed();
    }

    public function shipping() {
        return $this->belongsTo('\App\Models\ListingShippingOption')->withTrashed();
      }

    public function payment_type()
    {
          return $this->belongsTo('\App\Models\PaymentType');
    }


    public function seller() {
      return $this->belongsTo('App\Models\User', 'seller_id');
    }
	
    public function user() {
      return $this->belongsTo('App\Models\User');
    }

}
