<?php


Route::get('/', function () {
    return view('welcome');
}); 

Route::post('/pay-payment','PaymentController@payment')->name('payment');
Route::get('/execute','PaymentController@execute');
Route::get('/cancel',function (){
    return "ok";
});


Route::get('/create/plan','SubscriptionController@createPlan');
Route::get('/create/list','SubscriptionController@seePlanList');
Route::get('/create/plan/{id}','SubscriptionController@showPlanDetails');
Route::get('/create/plan/{id}/active','SubscriptionController@planActive');