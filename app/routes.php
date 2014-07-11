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
Route::model('twitter', 'TwitterOAuth');
Route::model('insta', 'Instagram');

/*Facebook Login Test code  - Inserted by Ricky */
Route::get('FBlogin-test', function()
	{
		return View::make('FBlogin-test');
	});

//handles post request from FBlogin-test.
Route::post('login', function()
	{	
		//catches the info
		$email = $_REQUEST['email'];
		$token = $_REQUEST['FBtoken'];

		//checks to see if user exists in DB
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
		//creates new instagram object 
		$insta = new Instagram(array(
			'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
			'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
			'apiCallback' =>	'http://localhost.socialnukemain.com/instagramCallback'
		));

		//set redirect URL
		$redirect = $insta->getLoginUrl(array(
			'basic',
			'relationships'
		));

		//saves instagram object in session
		Session::put('instagram', $insta);

		$response['redirect'] = $redirect;
		$response['success'] = true;
		return json_encode($response);
	});

Route::get('callback', function()
{
	

});

Route::post('settingsTwitter', function()
{
	try {
		$twitter = new TwitterOAuth('hPt7qgK7t1gutuGvbpKRtw', 'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E');
		$request_token = $twitter->getRequestToken('http://localhost.socialnukemain.com/callback');
		$token = $request_token['oauth_token'];
	    $url = $twitter->getAuthorizeURL($token);
	    
	    $response['success'] = true;
	    $response['redirect'] = $url;
	    $response['user'] = $_REQUEST;
	    return $response;

	} catch (Exception $e) {
		echo $e->getMessage();
	}
});
	
Route::post('settingsSnapchat', function()
 	{
 		//code
 	});

/************Handles all the callback urls*************/
Route::get('instagramCallback', function()
	{
		//retrieves instagram object from session
		$insta = Session::get('instagram');

		//retrieves the access token
		$code = $_GET['code'];	
		$data = $insta->getOAuthToken($code);

		//sets access token in instagram object
		$insta->setAccessToken($data);

		//saves updated instagram object in session
		Session::put('instagram', $insta);
		
		//test to see whether Instagram works
		'Your username is: ' . $data->user->username;
	});

Route::get('twitterCallback', function()
{
	//code
});

Route::get('snapchatCallback', function()
{
	//code
});