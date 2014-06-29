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
Route::model('user', 'User');

/*Facebook Login Test code  - Inserted by Ricky */
Route::get('FBlogin-test', function()
{
	return View::make('FBlogin-test');
});

//handles post request from FBlogin-test.
Route::post('login', function()
{	
	$email = $_REQUEST['email'];
	$token = $_REQUEST['FBtoken'];
	if($user = User::find($email)==true)
	{
		$user = User::find($email);
		echo $user;
	}
	else
	{
		$user = new User();
		$user->email = $email;
		$user->facebookToken = $token;
		$user->save();
		echo $user;
	}
});

Route::get('settings-test', function()
{
	return View::make('settings-test');
});

/*****Handles posts from settings page******/
Route::post('settingsInstagram', function()
{
	//code
});

Route::post('settingsTwitter', function()
{
	//code
});

Route::post('settingsSnapchat', function()
 {
 	//code
 });



/******Handles all the callback urls*******/
Route::post('instagramCallback', function()
{
	//code
});

Route::post('twitterCallback', function()
{
	//code
});

Route::post('snapchatCallback', function()
{
	//code
});
