<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


include "admin.php";
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});


Route::group(['middleware' => ['jailBanned']], function()
{
    Auth::routes();

    Route::get('/password/reset', 'Auth\ForgotPasswordController@indexPage')->name('page_resetpassword');
    Route::post('/password/reset', 'Auth\ForgotPasswordController@verifyPage')->name('verify_password');

    Route::get('/account/reset/token/{token}', 'Auth\ForgotPasswordController@resetPasswordPage')->name('reset_password');
    Route::post('/account/reset/token/save', 'Auth\ForgotPasswordController@savePasswordReset')->name('reset_password');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/mnemonic', 'Auth\LoginController@mnemonicPage')->name('mnemonic');
    Route::post('/mnemonic', 'Auth\LoginController@mnemonicPost')->name('mnemonic_post');

    Route::get('/two_factor_auth', 'Auth\LoginController@pGP2FACheckP')->name('2fa_factor');
    Route::post('/two_factor_auth', 'Auth\LoginController@verifyTwoFactorAuth')->name('2fa_factorcheck');
  

    Route::get('/captcha.html', 'Auth\LoginController@captcha');




	//ACCOUNT
	Route::group(['middleware' => ['auth','auth.mnemonic'], 'prefix' => 'account', 'as' => 'account.', 'namespace' => 'Account'], function()
	{

		Route::get('/', function () {
			return redirect(route('account.edit_profile.index'));
		});
		Route::resource('change_password', 'PasswordController');
        Route::get('edit_profile', 'ProfileController@index');
        Route::get('edit_profile/me', 'ProfileController@edit');
        Route::post('edit_profile/me', 'ProfileController@storeProfile')->name('update.profile');

        Route::get('change_pgp', 'ProfileController@pgp_key');
        Route::post('change_pgp', 'ProfileController@pgpUpdate')->name('update.pgp');

        Route::get('vendor_settings', 'ProfileController@vendor_settings');
        Route::post('vendor_settings', 'ProfileController@updateStore')->name('update.store');

        Route::get('verify_pgp', 'ProfileController@pgpVerifyPage');
        Route::post('verify_pgp', 'ProfileController@verifyPGP')->name('verify.pgp');

        
        Route::get('multisig', 'ProfileController@multisig');
        Route::post('multisig', 'ProfileController@multisigUpdate');

        Route::get('/buy/ads/{listing}', 'AdsController@index')->name('ads');

        Route::post('/buy/ads/{listing}', 'AdsController@buyingAds')->name('ads.buyingads');




        Route::get('addresses', 'ProfileController@addresses');
    


        Route::get('feedbacks', 'ProfileController@feedbacks');

        Route::resource('purchase-history', 'PurchaseHistoryController');
        Route::get('purchase-history/{purchase_history}/feedback', 'PurchaseHistoryController@feedbackPage')->name('purchase-history.feedback');
        Route::post('purchase-history/{purchase_history}', 'PurchaseHistoryController@update')->name('give.feedback');
        Route::post('purchase-history/{purchase_history}/finalize', 'PurchaseHistoryController@finalizeOrder')->name('finalize.order');


        
        Route::resource('favorites', 'FavoritesController');
        Route::post('favorites/remove', 'FavoritesController@remove')->name('remove.favorites');
        

        Route::resource('listings', 'ListingsController');
        Route::post('listings', 'ListingsController@removeAll')->name('remove.listings');
        Route::resource('orders', 'OrdersController');
        Route::post('/orders/{order}', 'OrdersController@update');
        Route::post('0/update/orders', 'OrdersController@updateAll')->name('update.orders');

        Route::get('/orders/state/1', 'OrdersController@accepted')->name('orders.accepted');
        Route::get('/orders/state/2', 'OrdersController@shipped')->name('orders.shipped');
        Route::get('/orders/state/3', 'OrdersController@finalized')->name('orders.finalized');
        Route::get('/orders/state/4', 'OrdersController@dispute')->name('orders.dispute');
        Route::get('/orders/state/5', 'OrdersController@cancelled')->name('orders.cancelled');


        Route::get('disputes', 'DisputeController@index');
        Route::get('dispute/0/{id}', 'DisputeController@dispute')->name('dispute.show');
        Route::post('dispute/0/{id}/create', 'DisputeController@createDispute')->name('dispute.create');
        Route::post('dispute/0/{id}/sendmessage', 'DisputeController@sentMessage')->name('dispute.message');
        Route::post('dispute/0/{id}/cancel', 'DisputeController@cancel')->name('dispute.cancel');

        Route::get('disputes/moderator','DisputeController@ModeratorIndex')->name('dispute.moderator');
        Route::get('disputes/moderator/decide/{id}','DisputeController@ModeratorDecide')->name('dispute.decide');
        Route::post('disputes/moderator/decide/{id}/{winner}','DisputeController@ModeratorDecision')->name('dispute.decision');

        Route::get('wallet', 'WalletController@index')->name('wallet');

        Route::get('apply_vendor', 'ProfileController@applyVendor')->name('page.vendor');
        Route::post('apply_vendor', 'ProfileController@payVendor')->name('pay.vendor');




        Route::get('wallet/btc', 'BitcoinController@index')->name('bitcoin-wallet');
        Route::get('wallet/xmr', 'MoneroController@index')->name('monero-wallet');
        Route::get('wallet/ltc', 'LiteCoinController@index')->name('litecoin-wallet');

        Route::post('withdraw/btc', 'BitcoinController@Withdraw')->name('bitcoin-withdraw');
        Route::post('withdraw/xmr', 'MoneroController@Withdraw')->name('monero-withdraw');
        Route::post('withdraw/ltc', 'LiteCoinController@Withdraw')->name('litecoin-withdraw');

    });

	//REQUIRES AUTHENTICATION
	Route::group(['middleware' => ['auth','auth.mnemonic']], function () {

        Route::get('/', 'BrowseController@listings')->name('browse');
        Route::get('/exchanges/{exchange}','BrowseController@exchange')->name('exchange');
        Route::get('/categories', 'BrowseController@categories')->name('categories');


		//INBOX
        Route::resource('inbox', 'InboxController')->middleware('talk'); //Inbox
        
        Route::post('/inbox/sendmessage', 'InboxController@sendMessage')->name('send.message');
        Route::post('/inbox/{id}/report', 'InboxController@report')->name('report.message');




        Route::get('notifications', 'NotificationController@index')->name('notifications');
        Route::get('notifications/delete/{id}', 'NotificationController@delete')->name('notifications');
        Route::get('notifications/go/{id}', 'NotificationController@go')->name('notifications');
        Route::get('notifications/markread', 'NotificationController@markAllRead')->name('notifications');
        Route::get('notifications/empty', 'NotificationController@deleteAllNotifications')->name('notifications');



        Route::get('/profile/{user}', 'ProfileController@index')->name('profile'); //PROFILE
        Route::get('/profile/{user}/follow', 'ProfileController@follow')->name('profile.follow'); //PROFILE
        Route::get('/profile/{user}/store', 'ProfileController@storeShop')->name('profile.storeshop'); //PROFILE
        Route::get('/profile/{user}/ratings', 'ProfileController@reviews')->name('profile.ratings'); //PROFILE
        Route::get('/profile/{user}/sendmessage', 'ProfileController@createMessageViaListing')->name('profile.messages'); //PROFILE
        Route::post('/profile/{userId}/sendmessage', 'ProfileController@storeMessageViaProfile')->name('profile.sendmessage'); //PROFILE
        Route::post('/profile/{user}/report', 'ProfileController@submit')->name('profile.report'); //PROFILE

        Route::get('/help', 'HelpController@index')->name('page');
        Route::get('/help/{id}', 'HelpController@help')->name('page');
        Route::post('/help/search', 'HelpController@search')->name('help_search');
        Route::get('/help/{id}/voteup', 'HelpController@voteUp');
        Route::get('/help/{id}/votedown', 'HelpController@voteDown');
        
    
        Route::get('/category/{id}', 'CategoryController@index')->name('category.index');
        Route::post('/category/{id}/search', 'CategoryController@filter')->name('category.filter');



	//LISTINGS
	Route::group(['prefix' => 'listing'], function()
	{
		Route::get('/{listing}/{slug}', 'ListingController@index')->name('listing');
		Route::get('/{listing}/{slug}/card', 'ListingController@card')->name('listing.card');
		Route::get('/{listing}/{slug}/spotlight', 'ListingController@spotlight')->middleware('auth.ajax')->name('listing.spotlight');
        Route::get('/{listing}/{slug}/message', 'InboxController@createMessageViaListing')->middleware('auth.ajax')->name('listing.sendmessage');
		Route::post('/{listing}/{slug}/message', 'InboxController@store')->middleware('auth.ajax')->name('listing.storemessage');
        Route::get('/{listing}/{slug}/star', 'ListingController@star')->middleware('auth.ajax')->name('listing.star');
        Route::get('/{listing}/{slug}/follow', 'ListingController@follow')->middleware('auth.ajax')->name('listing.follow');
		Route::get('/{listing}/{slug}/edit', 'ListingController@edit')->name('listing.edit');
        Route::any('/{id}/update', 'ListingController@update')->name('listing.update');
    

	});



		//CREATE LISTING
        
        Route::get('/create/listing', 'CreateController@index')->name('listing.creat');
        Route::post('/create/listing', 'CreateController@store')->name('listing.create');
        Route::get('/clone/{listing}/listing', 'CreateController@clone')->name('listing.clone');


        Route::get('/edit/{listing}/listing', 'CreateController@edit')->name('listing.edit');
        Route::post('/update/{listing}/listing', 'CreateController@update')->name('listing.update');




        Route::any('/create/{listing}/session', 'CreateController@session')->name('create.session');
        Route::get('/create/{listing}/images', 'CreateController@images')->name('create.images');
        Route::get('/create/{listing}/additional', 'CreateController@additional')->name('create.additional');
        Route::get('/create/{listing}/pricing', 'CreateController@pricing')->name('create.pricing');
        Route::get('/create/{listing}/times', 'CreateController@getTimes')->name('create.times');
        Route::post('/create/{listing}/times', 'CreateController@postTimes')->name('create.times');
        Route::get('/create/{listing}/boost', 'CreateController@boost')->name('create.boost');

        Route::post('/create/{listing}/uploads', 'CreateController@upload')->name('create.upload');
        Route::delete('/create/{listing}/image/{uuid?}', 'CreateController@deleteUpload')->name('create.delete-image');

        #Route::delete('/uploads/delete/{id}', array('as' => 'upload', 'uses' => 'CreateController@deleteUpload'))->name('create.delete-image');;
		#Route::get('/listings/{id}/session', array('as' => 'create', 'uses' => 'CreateController@session'));

		//CHECKOUT
        Route::get('/checkout/error', 'CheckoutController@error_page')->name('checkout.error');
        Route::get('/checkout', 'CheckoutController@index')->name('checkout');
        Route::get('/checkout/multisig/{address}', 'CheckoutController@CheckMultisig')->name('multisig');
        Route::get('/checkout/{listing}', 'CheckoutController@index')->name('checkout');


        Route::post('/checkout/{listing}', 'CheckoutController@checkout')->name('checkout.store');
        Route::post('/checkout', 'CheckoutController@placingOrder')->name('placing.order');


    });
});
Route::get("/rates","TransactionsController@UpdateRates");
Route::post("/transactions/btc","TransactionsController@DepositBitcoin");
Route::post("/transactions/ltc","TransactionsController@DepositLitecoin");
Route::post("/transactions/xmr","TransactionsController@DepositMonero");
Route::get("/transactions/cron","TransactionsController@Cron");
#errors
Route::get('/suspended',function(){
    return 'Sorry something went wrong.';
})->name('error.suspended');