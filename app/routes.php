<?php

/*
|--------------------------------------------------------------------------
| Application Filters
|--------------------------------------------------------------------------
|
| We put the filters up here so that jeffery way's generator routes
| get placed at the bottom of the file
|
*/

// check that a user doesn't have a force pw reset
Route::filter('passwordCheck', function(){
    // if the user is logged in
    // but doesn't have a password
    if(Auth::check() && Auth::user()->force_password_change) {
        // send them to the passwordChange route
        return Redirect::route('passwordChange');
    }
});


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// filter all routes through the password check
Route::group(['before'=>'passwordCheck'], function(){
    /*
     * Our Home Routes
     */
    Route::get('/', ['as'=>'home', 'uses'=>'HomeController@index']);
    

    // eventually we will want to remove this route all together
    Route::get('login', ['as'=>'getLogin', 'uses'=>'UsersController@getLogin']);
    Route::get('login/fb', ['as'=>'facebookLogin', 'uses'=>'UsersController@facebookLogin']);
    Route::get('login/fb/callback', ['as'=>'facebookCallback', 'uses'=>'UsersController@facebookCallback']);

    Route::post('login', ['as'=>'users.login', 'uses'=>'UsersController@login']);
    Route::resource('users', 'UsersController');    
});

// our password change route 
Route::get('pw', ['before'=>'auth','as'=>'passwordChange', 'uses'=>'UsersController@passwordChange']);
Route::post('pw', ['before'=>'auth','as'=>'passwordStore', 'uses'=>'UsersController@passwordStore']);
// make sure logout is accesable
Route::get('logout', ['as'=>'logout', 'uses'=>'UsersController@logout']);
Route::get('credits', ['as'=>'credits', 'uses'=>'HomeController@credits']);