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
Route::model('snapchat', 'Snapchat');

/*Initial Login code */
Route::get('/', function()
	{
		return View::make('login');
	});

Route::post('update', function()
	{
		$user = Session::get('user');

		$response['success'] = true;
		$response['activation']['facebookActivation'] = $user->facebookActivation;
		$response['activation']['instagramActivation'] = $user->instagramActivation;
		$response['activation']['twitterActivation'] = $user->twitterActivation;
		$response['activation']['snapchatActivation'] = $user->snapchatActivation;
		$response['activation']['phoneActivation'] = $user->phoneActivation;

		return $response;
	});

####### MOMO's ID: 625348784 			#######
####### Rick's twitter: realrickmorales #######
####### Rick's snapchat: muzangles 		#######
Route::post('launchNuke', function()
	{
		$user = Session::get('user');
		//$twitter = Session::get('twitter');
		//$insta = Session::get('insta');
		//$snapchat = Session::get('snapchat');

		//pulls all info needed from request
		$twitterTarget = $_REQUEST['Twitter'];
		$instaTarget = $_REQUEST['Instagram'];
		$snapTarget = $_REQUEST['Snapchat'];
		$phoneTarget = $_REQUEST['Phone'];

		//only runs the deletion code if something was put into form
		if(strlen($twitterTarget)>0) {
			$token = $user->twitterToken;
			$secret = $user->twitterSecret;

			$final_connection = new TwitterOAuth(
				'hPt7qgK7t1gutuGvbpKRtw',
				'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E',
				$token,
				$secret
			);
			$destroyUser = $final_connection->post('friendships/destroy', array('screen_name' => $twitterTarget));
		}

		if(strlen($instaTarget)>0) {
			$token = $user->instagramToken;
			$insta = new Instagram(array(
				'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
				'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
				'apiCallback' =>	'http://socialnuke.me/instagramCallback'
			));
			$insta->setAccessToken($token);
			$insta->modifyRelationship('unfollow', $instaTarget);
		}

		if(strlen($snapTarget)>0) {
			$username = $user->snapchatUsername;
			$pass = $user->snapchatPassword;

			$snapchat = new Snapchat($username, $pass);
			$snapchat->deleteFriend($snapTarget);
		}

		if(strlen($phoneTarget)>0) {
			//delete contact
		}
		$targetName = $twitterTarget . ", "
					. $instaTarget . ", "
					. $snapTarget . ", "
					. $phoneTarget;

		$response['targetName'] = $targetName;
		$response['success'] = true;

		return $response;
	});

//handles post request from FBlogin-test.
Route::post('login', function()
	{	
		Session::clear();
		try {

			//catches the info
			$email = $_REQUEST['email'];
			$token = $_REQUEST['FBtoken'];

			//checks to see if user exists in DB
			$validator = Validator::make(
				array('email' => $email),
				array('email' => 'exists:users,email')
			);

			if($validator->passes()) {
				$user = User::where('email', '=', $email)->first();
			}
			else {
				$user = new User();
				$user->email = $email;
				$user->facebookToken = $token;
				$user->save();
			}

			Session::put('user', $user);
			$response['user'] = $user;

			$response['success'] = true;
			$response['redirect'] = 'settings';
			$response['activation']['facebookActivation'] = $user->facebookActivation;
			$response['activation']['instagramActivation'] = $user->instagramActivation;
			$response['activation']['twitterActivation'] = $user->twitterActivation;
			$response['activation']['snapchatActivation'] = $user->snapchatActivation;
			$response['activation']['phoneActivation'] = $user->phoneActivation;

			return $response;
		}

		catch (Exception $e) {
			echo $e-getMessage();
		}

	});

Route::get('settings', function()
	{
		return View::make('settings');
	});

/*****Handles posts from settings page******/
Route::post('settingsInstagram', function()
	{
		// If setting is already activated, deactivate and return
		$user = Session::get('user');
		if($user->instagramActivation) {
			$user->instagramActivation = 0;
			$user->save();

			// Update user in session
			Session::put('user', $user);

			$response['success'] = true;
			return $response;
		}

		//creates instagram object
		$insta = new Instagram(array(
			'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
			'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
			'apiCallback' =>	'http://socialnuke.me/instagramCallback'
		));

		$instaToken = $user->instagramToken;
		if($instaToken!=null)
			{
				// Sets token equal to element in database
				$token = $user->instagramToken;
				$insta->setAccessToken($token);

				// Stores instagram object in session
				Session::put('instagram', $insta);
				
				//creates part of response object
				//$response['redirect'] = 'http://socialnuke.me/settings';

				// Update activation setting in user and session
				$user->instagramActivation = 1;
				$user->save();

				// Update user in session
				Session::put('user', $user);

				// Creates part of the response object
				$response['redirect'] = 'settings';
				$response['activation']['facebookActivation'] = $user->facebookActivation;
				$response['activation']['instagramActivation'] = $user->instagramActivation;
				$response['activation']['twitterActivation'] = $user->twitterActivation;
				$response['activation']['snapchatActivation'] = $user->snapchatActivation;
				$response['activation']['phoneActivation'] = $user->phoneActivation;

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

		// Creates rest of response object and returns it
		$response['success'] = true;
		return $response;
	});

Route::post('settingsTwitter', function()
	{
		// If setting is already activated, deactivate and return
		$user = Session::get('user');
		if($user->twitterActivation) {
			$user->twitterActivation = 0;
			$user->save();

			// Update user in session
			Session::put('user', $user);

			$response['success'] = true;
			return $response;
		}

		try {
			//creates new TwitterOAuth object 
			$twitter = new TwitterOAuth(
				'hPt7qgK7t1gutuGvbpKRtw',
				'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E'
			);

			$token = $user->twitterToken;
			$secret = $user->twitterSecret;

			if($token&&$secret!=null) 
				{
					$final_connection = new TwitterOAuth(
						'hPt7qgK7t1gutuGvbpKRtw',
						'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E',
						$token,
						$secret
					);

					$user->twitterActivation = 1;
					$user->save();

					// Updates the session
					Session::put('twitter', $final_connection);
					Session::put('user', $user);

					// Creates part of the response object
					$response['redirect'] = 'settings';
					$response['activation']['facebookActivation'] = $user->facebookActivation;
					$response['activation']['instagramActivation'] = $user->instagramActivation;
					$response['activation']['twitterActivation'] = $user->twitterActivation;
					$response['activation']['snapchatActivation'] = $user->snapchatActivation;
					$response['activation']['phoneActivation'] = $user->phoneActivation;
				}
			else 
				{
					// Retrieve temporary credentials and store temporary OAuth token
					$temporary_credentials = $twitter->getRequestToken('http://socialnuke.me/twitterCallback');
					$temporary_token = $temporary_credentials['oauth_token'];

					// Store temporary credentials into session for later use in callback
				    Session::put('twitter_temp_cred', $temporary_credentials);

					// Retrieve redirect URL using temporary OAuth token		
				    $redirect = $twitter->getAuthorizeURL($temporary_token);
				    
				    // Send redirect URL back to mobile device
				    $response['redirect'] = $redirect;
		    	}

		    // Finalize response object and return
		    $response['success'] = true;
		    return $response;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	});
	
Route::post('settingsSnapchat', function()
 	{
 		// If setting is already activated, deactivate and return
 		$user = Session::get('user');
		if($user->snapchatActivation) {
			$user->snapchatActivation = 0;
			$user->save();

			// Update user in session
			Session::put('user', $user);
			$response['success'] = true;
			return $response;
		}

 		$username = $user->snapchatUsername;
 		$password = $user->snapchatPassword;
 		if($username&&$password!=null) 
 			{	
 				$snapchat = new Snapchat($username, $password);
 				Session::put('snapchat', $snapchat);
 				$user->snapchatActivation = 1;
				$user->save();
				Session::put('user', $user);
 				$response['redirect'] = 'settings';
 			}
 		else 
 			{
 				// Send redirect URL back to mobile device
	    		$response['redirect'] = 'snapchatLogin';
 			}

 		// Send redirect URL back to mobile device
	    $response['success'] = true;
	    $response['activation']['facebookActivation'] = $user->facebookActivation;
		$response['activation']['instagramActivation'] = $user->instagramActivation;
		$response['activation']['twitterActivation'] = $user->twitterActivation;
		$response['activation']['snapchatActivation'] = $user->snapchatActivation;
		$response['activation']['phoneActivation'] = $user->phoneActivation;
		return $response;
 	});

/************Handles all the callback urls*************/
Route::get('nuke', function()
	{
		return View::make('nuke-page');
	});

Route::post('settingsPhone', function()
	{
		// If setting is already activated, deactivate and return
		$user = Session::get('user');
		if($user->phoneActivation) {
			$user->phoneActivation = 0;
			$user->save();

			// Update user in session
			Session::put('user', $user);

			$response['success'] = true;
			return $response;
		}
		$user->phoneActivation = 1;
		$user->save();

		// Send redirect URL back to mobile device
	    $response['redirect'] = 'settings';
	    $response['success'] = true;
	    $response['activation']['facebookActivation'] = $user->facebookActivation;
		$response['activation']['instagramActivation'] = $user->instagramActivation;
		$response['activation']['twitterActivation'] = $user->twitterActivation;
		$response['activation']['snapchatActivation'] = $user->snapchatActivation;
		$response['activation']['phoneActivation'] = $user->phoneActivation;
		return $response;
	});

Route::get('instagramCallback', function()
	{
		try {

			//retrieves instagram object from session
			$insta = Session::get('instagram');
			$user = Session::get('user');

			//retrieves the access token
			$code = $_GET['code'];	
			$data = $insta->getOAuthToken($code);

			//sets access token in instagram object
			$insta->setAccessToken($data);
			$token = $insta->getAccessToken();

			// Update instagram settings in user
			$user->instagramToken = $token;
			$user->instagramActivation = 1;
			$user->save();

			// Updates the session
			Session::put('instagram', $insta);
			Session::put('user', $user);

			// Creates the response object
			$response['success'] = true;
			$response['redirect'] = 'settings';
			$response['activation']['facebookActivation'] = $user->facebookActivation;
			$response['activation']['instagramActivation'] = $user->instagramActivation;
			$response['activation']['twitterActivation'] = $user->twitterActivation;
			$response['activation']['snapchatActivation'] = $user->snapchatActivation;
			$response['activation']['phoneActivation'] = $user->phoneActivation;

			return $response;

		} catch(Exception $e) {
			echo $e->getMessage();
		}
	});

Route::get('twitterCallback', function()
	{

		try {

			$user = Session::get('user');
			$temporary_credentials = Session::get('twitter_temp_cred');
			
			// Build a new TwitterOAuth object using temporary credentials
			$twitter = new TwitterOAuth(
				'hPt7qgK7t1gutuGvbpKRtw',
				'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E',
				$temporary_credentials['oauth_token'],
				$temporary_credentials['oauth_token_secret']
			);

			//retrieves the final access token
			$final_credentials = $twitter->getAccessToken(
				$_GET['oauth_verifier'],
				$temporary_credentials['oauth_token'],
				$temporary_credentials['oauth_token_secret']
			);

			// Build a final TwitterOAuth object using final credentials
			$final_connection = new TwitterOAuth(
				'hPt7qgK7t1gutuGvbpKRtw',
				'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E',
				$final_credentials['oauth_token'],
				$final_credentials['oauth_token_secret']
			);

			$token = $final_credentials['oauth_token'];
			$secret = $final_credentials['oauth_token_secret'];
			
			$user->twitterToken = $token;
			$user->twitterSecret = $secret;
			$user->twitterActivation = 1;
			$user->save();

			Session::put('twitter', $final_connection);
			Session::put('user', $user);

			// Creates the response object
			$response['success'] = true;
			$response['redirect'] = 'settings';
			$response['activation']['facebookActivation'] = $user->facebookActivation;
			$response['activation']['instagramActivation'] = $user->instagramActivation;
			$response['activation']['twitterActivation'] = $user->twitterActivation;
			$response['activation']['snapchatActivation'] = $user->snapchatActivation;
			$response['activation']['phoneActivation'] = $user->phoneActivation;

			return $response;
		
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	});

/*=====================================
SnapChat Login and Callback
======================================*/

Route::get('snapchatLogin', function()
	{
		return View::make('snapchat-login');
	});

Route::post('snapchatConnect', function()
{
	try {

		$snapchat = new Snapchat($_REQUEST['user'], $_REQUEST['password']);

		if ($snapchat->returnSuccess()) { 

			$user = Session::get('user');
			
			$user->snapchatUsername = $_REQUEST['user'];
			$user->snapchatPassword = $_REQUEST['password'];
			$user->snapchatActivation = 1;
			$user->save();

			Session::put('snapchat', $snapchat);
			Session::put('user', $user);

			$response['success'] = true;
			$response['redirect'] = 'settings';
			$response['activation']['facebookActivation'] = $user->facebookActivation;
			$response['activation']['instagramActivation'] = $user->instagramActivation;
			$response['activation']['twitterActivation'] = $user->twitterActivation;
			$response['activation']['snapchatActivation'] = $user->snapchatActivation;
			$response['activation']['phoneActivation'] = $user->phoneActivation;
		}
		else {
			$response['success'] = false;
		}
		return $response;

	} catch (Exception $e) {
		echo 'Error : ' . $e->getMessage();
	}

});