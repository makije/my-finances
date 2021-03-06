<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'PagesController@showWelcome');

    Route::group(['prefix' => 'auth'], function() {
        Route::auth();
    });

    Route::get('/profile', 'ProfileController@showProfile');

    Route::group(['prefix' => 'account'], function(){
        Route::get('/', 'AccountController@showAccounts');

        Route::get('/add', 'AccountController@addAccount');
        Route::post('/add', 'AccountController@createAccount');

        Route::get('/{account}', 'AccountController@showAccount');

        Route::get('/{account}/add-transaction', 'AccountController@addTransaction');
        Route::post('/{account}/add-transaction', 'AccountController@addTransactionToAccount');
        Route::post('/{account}/add-transactions', 'AccountController@addTransactionsFromCsvToAccount');
    });

});
