<?php

use Orion\Facades\Orion;

use Modules\Memberships\Http\Controllers\Settings\MembershipSettingsController;


Route::group([
    'as' => 'memberships.',
    'prefix' => 'memberships',
    "middleware" => ["web","auth","role:admin|editor|analyzer|guest"]
], function ($router) {


    Route::resource('plans', 'PlanController');

 
    Route::resource('subscriptions', 'SubscriptionsController');

    Route::get('subscriptions/cancel', 'SubscriptionsController@cancel')->name("subscriptions.cancel");


    Route::get('memberships/renew/{subscription}', 'SubscriptionRenewController@renew')->name('memberships.renew');


      // Membership settings
        Route::get('settings', [MembershipSettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [MembershipSettingsController::class, 'store'])->name('settings.store');

  

 

});



      