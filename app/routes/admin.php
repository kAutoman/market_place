<?php

Route::group(['as' => 'panel.', 'prefix' => 'panel', 'middleware' => ['web', 'role:admin'], 'namespace' => '\Admin'], function()
{
    Route::get('/', 'PanelController@index');
    Route::resource('listings', 'ListingsController');
	Route::get('/listings/{listing}/duplicate', 'ListingsController@duplicate')->name('listings.duplicate');
    Route::resource('categories', 'CategoriesController');
	Route::resource('roles', 'RolesController');
    Route::resource('pages', 'PagesController');
    Route::resource('menu', 'MenuController');
    Route::any('/settings/remove', 'SettingsController@remove')->name('settings.remove');
    Route::resource('payments', 'PaymentsController');
    Route::get('/changePaymentStatus/{id}','PaymentsController@changeStatus');
    Route::resource('settings', 'SettingsController');
    Route::resource('orders', 'OrdersController');
    Route::resource('home', 'HomeController');
    Route::resource('addons', 'AddonsController');
    Route::get('/addon/{id}/toggle', 'AddonsController@toggle');
    Route::resource('pricing-models', 'PricingModelsController');
    Route::resource('fields', 'FieldsController');

});

Route::group(['as' => 'panel.', 'prefix' => 'panel', 'middleware' => ['web', 'role:admin|moderator'], 'namespace' => '\Admin'], function()
{
    Route::get('/', 'PanelController@index');
    Route::any('userdelete/{id}','UsersController@destroy');
    Route::any('useredit/{id}','UsersController@edit');
    Route::any('useredit/{id}','UsersController@edit');
    Route::any('userUpdate','UsersController@update');
    Route::resource('users', 'UsersController');

});