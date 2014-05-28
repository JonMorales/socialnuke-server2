<?php
class InstagramController extends BaseController {

	//create registration form
	public function showInstagram()
	{
		return View::make('settings');
	}

	//processes form, making sure that each field is filled in
	public function createInstagram()
	{
	$instagram = new Instagram(array(
		'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
		'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
		'apiCallback' =>	'http://localhost/socialnukemain/public/callback'
		));
	
	return Redirect::away($instagram->getLoginUrl(array(
		'basic',
		'relationships'
		)));
	}

	public function callback()
	{
		$instagram = new Instagram(array(
		'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
		'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
		'apiCallback' =>	'http://localhost/socialnukemain/public/callback'
		));

		$code = $_GET['code'];
		$data = $instagram->getOAuthToken($code);

		$instagram -> setAccessToken($data);

		$token = $instagram->getAccessToken();

		//saves token in database
		$user = User::all();
		$user= User::find(1);
		$user->token = $token;
		$user->save();

		return View::make('callback');
	}

	public function unfollow()
	{
		$instagram = new Instagram(array(
		'apiKey' => 'cdb1435d1d8747cdba5d79788011bf66',
		'apiSecret' =>	'6e8c792d25e04ff79f03e6c3cc5b076f',
		'apiCallback' =>	'http://localhost/socialnukemain/public/callback'
		));

		$user= User::all();
		$user = User::find(1);

		$token = $user->token;
		$instagram ->setAccessToken($token);

    	//unfollows Momo 
    	$instagram -> modifyRelationship('unfollow', 625348784);
    	$relations = $instagram -> getUserRelationship(625348784);

    echo '<pre>';
    	print_r($relations);
    echo '</pre>';
	}
}