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
			}
		else
			{
				$user = new User();
				$user->email = $email;
				$user->facebookToken = $token;
				$user->save();
			}

		Session::put('user', $user);
	});

Route::get('settings-test', function()
	{
		return View::make('settings-test');
	});

/*****Handles posts from settings page******/
Route::post('settingsInstagram', function()
	{	 
		//creates instagram object
		$insta = new Instagram(array(
			'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
			'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
			'apiCallback' =>	'http://localhost.socialnukemain.com/instagramCallback'
		));

		$user = User::find('poop@poop.com');

		//this line will be used in actual app
		//$user = Session::get('user');

		$instaToken = $user->instagramToken;
		
		if($instaToken!=null)
			{
				//sets token equal to element in database
				$token = $user->instagramToken;

				$insta->setAccessToken($token);
				$token = $insta->getAccessToken();
				Session::put('instagram', $insta);
				
				//creates part of response object
				$response['redirect'] = 'http://localhost.socialnukemain.com/instagramCallback';
			}
		
		else
			{	
				//sets redirect URL
				$redirect = $insta->getLoginUrl(array(
					'basic',
					'relationships'
				));

				//creates part of response object
				$response['redirect'] = $redirect;
				Session::put('instagram', $insta);
			}
		//creates rest of response object and returns it
		$response['success'] = true;
		return json_encode($response);
	});

Route::post('settingsTwitter', function()
	{
		//code
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
		$likes=$insta->getUserLikes();
		echo '<pre>';
			print_r($likes);
		echo '<pre>';
	});

Route::get('twitterCallback', function()
{
	//code
});

Route::get('snapchatCallback', function()
{
	//code
});
