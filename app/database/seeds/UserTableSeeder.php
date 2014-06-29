<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'email' =>	'poop@poop.com',
			'facebookToken'	=>	'12345',
			'facebookActivation' =>	'0',
			'instagramToken'	=>	'6789',
			'instagramActivation' =>	'0',
			'twitterToken'	=>	'adsf24',
			'twitterActivation' =>	'0',
			'snapchatUsername'	=>	'assymcgee',
			'snapchatPassword' =>	'ggggg',
			'snapchatActivation' =>	'0',
			'phoneActivation' =>	'0'
		));
	}

}
