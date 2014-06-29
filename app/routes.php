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

/* Facebook Login Test code  - Inserted by Ricky */
Route::get('FBlogin-test', 'LoginController@makeLogin');


//show pages
//Route::get('login', array('uses' => 'HomeController@showLogin'));
Route::get('registration', array('uses' => 'RegisterController@showRegistration'));
Route::get('settings', 'InstagramController@showInstagram');
Route::get('callback', 'InstagramController@callback');

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

//handles form submissions
Route::post('registration', array('uses' => 'RegisterController@doRegistration'));
Route::post('settings', array('uses' => 'InstagramController@CreateInstagram'));
Route::post('callback', array('uses' => 'InstagramController@unfollow'));

