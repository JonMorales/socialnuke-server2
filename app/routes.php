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
			$response['redirect'] = 'settings-test';
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

		$user = Session::get('user');

		$instaToken = $user->instagramToken;
		if($instaToken!=null)
			{
				// Sets token equal to element in database
				$token = $user->instagramToken;
				$insta->setAccessToken($token);

				// Stores instagram object in session
				Session::put('instagram', $insta);
				
				// Update activation setting in user and session
				$user->instagramActivation = 1;
				$user->save();

				// Update user in session
				Session::put('user', $user);

				// Creates part of the response object
				$response['redirect'] = 'settings-test';
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
	try {
		//creates new TwitterOAuth object 
		$twitter = new TwitterOAuth(
			'hPt7qgK7t1gutuGvbpKRtw',
			'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E'
		);

		$user = Session::get('user');
		Session::put('user', $user);

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

				Session::put('twitter', $final_connection);

				$user->twitterActivation = 1;
				$user->save();

				$response['redirect'] = 'settings-test';
				$response['activation']['twitterActivation'] = true;
			}
		else 
			{
				// Retrieve temporary credentials and store temporary OAuth token
				$temporary_credentials = $twitter->getRequestToken('http://localhost.socialnukemain.com/twitterCallback');
				$temporary_token = $temporary_credentials['oauth_token'];

				// Store temporary credentials into session for later use in callback
			    Session::put('twitter_temp_cred', $temporary_credentials);

				// Retrieve redirect URL using temporary OAuth token		
			    $redirect = $twitter->getAuthorizeURL($temporary_token);
			    
			    // Send redirect URL back to mobile device
			    $response['redirect'] = $redirect;
	    	}

	    $response['success'] = true;
	    return $response;

	} catch (Exception $e) {
		echo $e->getMessage();
	}
});
	
Route::post('settingsSnapchat', function()
 	{
 		// Send redirect URL back to mobile device
	    $response['redirect'] = 'snapchatLogin';
	    $response['success'] = true;
		return json_encode($response);
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

			//creates part of response object
			$response['success'] = true;
			$response['redirect'] = 'settings-test';
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
		$user->save();

		Session::put('twitter', $final_connection);

		return View::make('settings-test');
		/*
		$destroyUser = $final_connection->post('friendships/destroy', array('screen_name' => 'steforzech'));
		print_r($destroyUser);
		*/ } catch (Exception $e) {
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
			
			$user->snapchatActivation = 1;
			$user->save();

			Session::put('snapchat', $snapchat);
			Session::put('user', $user);

			$response['success'] = true;
			$response['redirect'] = 'settings-test';
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