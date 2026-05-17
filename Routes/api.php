<?php

use Orion\Facades\Orion;

//Orion::resource('categories', CategoriesController::class);
//Orion::resource('categories', CategoriesController::class, ['except' => ['index', 'show', 'search']]);

Route::group([
    'as' => 'api.memberships.',
    'prefix' => 'memberships'
], function ($router) {



    Orion::resource('users', 'Api\UserController', ['only' => ['store']]);


    Route::middleware(['auth:api'])->group(function () {


      Orion::resource('users', 'Api\UserController',['except' => ['store']]);


      Orion::resource('plans', 'Api\PlanController');


      Orion::resource('subscriptions', 'Api\SubscriptionsController');
      
      
    //  Route::resource('subscription_history', 'Api\SubscriptionHistory');

   //   Route::resource('customers', 'Api\SubscriptionCustomers');


      //Route::post('subscription/cancel', 'Api\SubscriptionsController@cancel');

      //Route::post('subscription/test', 'Api\SubscriptionsController@test');


    });



});



Route::group([
  'as' => 'api.memberships.',
  'prefix' => 'memberships'
], function ($router) {


  /*

  Route::middleware(['auth.both:api'])->group(function () {
              
    Orion::resource('categories', 'Api\CategoriesController',['only' => ['index', 'show', 'search']]);
    
    Route::post('categories/{type}/search', 'Api\CategoriesController@children')->name("categories.children");    

    Route::post('categories/{type}/tree', 'Api\CategoriesController@tree')->name("categories.tree");
            
  });

  */


  Route::middleware(['auth:api'])->group(function() {

   // Orion::resource('categories', 'Api\CategoriesController', ['except' => ['index', 'show', 'search']]);

  });


});

