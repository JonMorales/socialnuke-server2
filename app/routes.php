<?php

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
Route::model('insta', 'instagram');

Route::get('/', function()
{
	return View::make('hello');
});

//show pages
//Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::get('registration', array('uses' => 'RegisterController@showRegistration'));
Route::get('settings', 'InstagramController@showInstagram');
Route::get('callback', 'InstagramController@callback');

//handles form submissions
Route::post('login', 'LoginController@doLogin');
Route::post('registration', array('uses' => 'RegisterController@doRegistration'));
Route::post('settings', array('uses' => 'InstagramController@CreateInstagram'));
Route::post('callback', array('uses' => 'InstagramController@unfollow'));


/* Facebook Login Test code  - Inserted by Ricky */
Route::get('/FBlogin-test', function()
{
	return View::make('FBlogin-test');
});