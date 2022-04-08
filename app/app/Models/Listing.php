<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CalculateTimeDiff;
use App\Models\Country;
use DB;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use App\Traits\Commentable;
use App\Traits\HashId;
use Date;
use Nicolaslopezj\Searchable\SearchableTrait;


class Listing extends Model
{
    use SearchableTrait;
    use Favoriteable;
    use Commentable;
    use SoftDeletes;
    use HashId;
    use CalculateTimeDiff;
    

    protected $canBeRated = true;
    protected $mustBeApproved = false;
    protected $table = 'listings';




    protected $searchable = [
        'columns' => [
            'listings.title' => 20,
            'listings.tags' => 10,
            'listings.description' => 10,
            'listings.tags_string' => 10,
            'users.username' => 10,
        ],
        'joins' => [
            'users' => ['users.id','listings.user_id'],
        ],
    ];

    protected $searchableColumns = ['title', 'tags', 'description'];
    protected $appends = ['thumbnail', 'price_formatted', 'url', 'slug', 'hash'];

    protected $fillable = [
        'key', 'title', 'price', 'stock', 'unit', 'category_id', 'user_id', 'short_address', 'description', 'spotlight', 'staff_pick', 'is_hidden', 'location', 'lat', 'lng', 'pricing_model_id', 'photos', 'city', 'region',  'country', 'currency', 'is_draft', 'session_duration', 'min_duration', 'max_duration'
    ];
    protected $casts = [
          'photos' => 'array',
          'meta' => 'json',
          'tags' => 'array',
          'shipping_options' => 'json',
          'variant_options' => 'json',
          'timeslots' => 'json',
    ];
    protected $spatialFields = [
    ];
    protected $dates = ['expires_at', 'spotlight', 'bold_until', 'priority_until', 'deleted_at', 'ends_at'];


    public function toggleSpotlight()
    {
        $this->spotlight = ($this->spotlight)?null:Carbon::now();
        $this->save();
    }

    public function getIsNewAttribute()
    {
        return !$this->is_published;
    }
	
  
    public function getDaysAgoAttribute($value) {
		return Date::parse($this->created_at)->ago();
	}

    public function getBoldAttribute() {
        if($this->bold_until && $this->bold_until->gt(Carbon::now())) {
            return true;
        }
        return false;
    }

	public function getHashAttribute(): string
    {
        return $this->getRouteKey();
    }
	
	
    public function getEditUrlAttribute() {
        return route('create.edit', [$this]);
    }

    public function getUrlAttribute() {
        return route('listing', [$this, $this->title]);
    }


    public function shipping_options()
    {
        return $this->hasMany('\App\Models\ListingShippingOption');
    }

    public function orders()
    {
        return $this->hasMany('\App\Models\Order');
    }


    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }

    public function listing_class()
    {
        return $this->belongsTo('\App\Models\ListingClass');
    }

    public function payment_type()
    {
        return $this->belongsTo('\App\Models\PaymentType');
    }

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
    

    public function countryNames() {
        if($this->ships_to == null) {
            $temporaryCountry = Country::where('id','1')->select('country_short_name')->get();
         return $temporaryCountry->toArray();
        }

        $ids = unserialize($this->ships_to);

        $country_short_names = Country::whereIn('id', $ids)->select('country_short_name')->get();
       
       
        return $country_short_names->toArray();
    }

    public function scopeActive($query)
    {
        return $query->where('is_published', 1);
    }

}
