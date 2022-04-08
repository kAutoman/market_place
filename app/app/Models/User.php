<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Avatar;
use App\Traits\CanComment;
use App\Traits\Commentable;
use ChristianKuri\LaravelFavorite\Traits\Favoriteability;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Kodeine\Metable\Metable;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Spatie\Permission\Traits\HasRoles;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanLike;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Gerardojbaez\Laraplans\Contracts\PlanSubscriberInterface;
use Gerardojbaez\Laraplans\Traits\PlanSubscriber;
use Depsimon\Wallet\HasWallet;
use Spatie\SchemalessAttributes\SchemalessAttributes;

class User extends Authenticatable implements BannableContract, JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use CanComment;
    use Commentable;
	use Favoriteability;
    use Bannable;
    use HasRoles;
    use CanFollow,CanBeFollowed;

    protected $canBeRated = true;
    protected $mustBeApproved = false;

	public function getRouteKey()
	{
		return $this->slug;
	}

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'avatar', 'bio', 'withdrawpin',  'unread_messages','pgp-key','2fa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


	public function payment_gateways()
    {
        return $this->hasMany('App\Models\PaymentGateway');
    }
	
	
	public function comments()
    {
        return $this->hasMany(Comment::class, 'seller_id');
    }

    public function owncomments()
    {
        return $this->hasMany(Comment::class, 'commenter_id');
    }

    
    public function getIsBannedAttribute()
    {
        return $this->isBanned();
    }

    public function getIsFollowed($value) {
        return $this->isFollowing($value);
    }

    public function listings() {
      return $this->hasMany('App\Models\Listing');
    }

    public function countDisputeWin() {
        $countWin = 0;
        foreach($this->disputesSeller as $dispute ) {
            if($dispute->resolved == 1) {
                if($dispute->winner == $this->id) {
                    $countWin = $countWin + 1;
                }
            }
        }
        return $countWin;
    }

    public function countDisputeLoss() {
        $countLoss = 0;
        foreach($this->disputesSeller as $dispute ) {
            if($dispute->resolved == 1) {
                if($dispute->winner != $this->id) {
                    $countLoss = $countLoss + 1;
                }
            }
        }
        return $countLoss;
    }

    public function countBuyerDisputeWin() {
        $countWin = 0;
        foreach($this->disputesBuyer as $dispute ) {
            if($dispute->resolved == 1) {
                if($dispute->winner == $this->id) {
                    $countWin = $countWin + 1;
                }
            }
        }
        return $countWin;
    }

    public function countBuyerDisputeLoss() {
        $countLoss = 0;
        foreach($this->disputesBuyer as $dispute ) {
            if($dispute->resolved == 1) {
                if($dispute->winner != $this->id) {
                    $countLoss = $countLoss + 1;
                }
            }
        }
        return $countLoss;
    }



    public function disputesBuyer() {
        return $this->hasMany('App\Models\Dispute','buyer_id');
    }

    public function disputesSeller() {
        return $this->hasMany('App\Models\Dispute','seller_id');
    }

    public function reports() {
        return $this->hasMany('App\Models\ReportedListing');
    }

    public function ifReportIsDone($user) {
        foreach($user->reports as $report) {
            if($report->reported_user == $this->id && $report->user_id == $user->id) {
                return true;
            }
        }
        return false;
    }

    public function ifReportConversationIsDone($id) {
        foreach($this->reports as $report) {
            if($report->reported_conversation == $id && $report->user_id == $this->id) {
                return true;
            }
        }
        return false;
    }

    public function getRememberToken()
    {
      return null; // not supported
    }

    public function setAttribute($key, $value)
    {
      $isRememberTokenAttribute = $key == $this->getRememberTokenName();
      if (!$isRememberTokenAttribute)
      {
        parent::setAttribute($key, $value);
      }
    }
    
    public function getAvatarBackground() {
        if(!$this->avatar_background) {
            return '/web/images/nobackground.png';
        }
        return $this->avatar_background;
    }

    public function getAvatar() {
        if(!$this->avatar) {
            return '/web/images/noavatar.png';
        }
        return $this->avatar;
    }

    // public function comments() {
    //   return $this->hasMany('App\Models\Comment', 'seller_id');
    // }

    public function markets() {
        return $this->hasMany('App\Models\UserMarket','user_id');
      }

    public function avg_rating() {
      return number_format($this->comments->avg('rating'), 1);
    }


    public function count_reviews() {
      return $this->comments()->whereNotNull('rate')->count('rate');
    }
    

    public function normal_orders() {
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    public function getTotalPriceSpend() {
        return number_format($this->normal_orders->sum('price'), 2);
    }

    public function getAvgSpending() {
        return number_format($this->getTotalPriceSpend()/$this->normal_orders->count(), 2);
    }

    public function getUnreadMessagesAttribute($value) {
        return max($value, 0);
    }
	
	
    public function orders() {
        return $this->hasMany('App\Models\Order', 'seller_id');
    }



    public function xmrBalance($subtract){
        if($subtract > $this->xmr_balance) {
            return false;
        } else {
            $this->xmr_balance = $this->xmr_balance - $subtract;
            $this->save();
            return true;
        }
    }

    public function btcBalance($subtract){
        if($subtract > $this->btc_balance) {
            return false;
        } else {
            $this->btc_balance = $this->btc_balance - $subtract;
            $this->save();
            return true;
        }
    }

    public function ltcBalance($subtract){
        if($subtract > $this->ltc_balance) {
            return false;
        } else {
            $this->ltc_balance = $this->ltc_balance - $subtract;
            $this->save();
            return true;
        }
    }

    public function GetBTCAddress(){
        $addresses = UserAddresses::where("user_id",$this->id)->first();
        
        return $addresses->btc_address;
    }

    public function GetLTCAddress(){
        $addresses = UserAddresses::where("user_id",$this->id)->first();
        return $addresses->ltc_address;
    }

    public function GetXMRAddress(){
        $addresses = UserAddresses::where("user_id",$this->id)->first();
        return $addresses->xmr_address;
    }

}
