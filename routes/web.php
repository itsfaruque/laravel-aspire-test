<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('fetch/{user_id}', 'UserController@getUsers');
    Route::post('create', 'UserController@create');
});

Route::group(['prefix' => 'loan'], function () {
    Route::get('fetch/{user_id}/{status?}', 'LoanController@getLoans');
    Route::post('create', 'LoanController@create');
    Route::post('update', 'LoanController@update');
});

Route::group(['prefix' => 'repayment'], function () {
    Route::get('fetch/{loan_id}', 'RepaymentController@getRepayments');
    Route::post('create', 'RepaymentController@create');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
