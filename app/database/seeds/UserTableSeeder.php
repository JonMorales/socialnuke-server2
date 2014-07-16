<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'email' =>	'user0@user.com',
			'facebookToken'	=>	'12345',
			'facebookActivation' =>	'0',
			'instagramToken'	=>	'401682282.cdb1435.8ae4572033f949c8bf5ec7642b350054',
			'instagramActivation' =>	'0',
			'twitterToken'	=>	'379541294-MFGRKdCeK8BxDSEb6sIsGcWudmtNZjbxQWOaXBQt',
			'twitterSecret' => 'pL5VvIvdamHoJP8OOE60L05faz2EIZBOjIfZnurAiQfXh',
			'twitterActivation' =>	'0',
			'snapchatUsername'	=>	'jonmorales69',
			'snapchatPassword' =>	'Ma121eY32',
			'snapchatActivation' =>	'0',
			'phoneActivation' =>	'0'
		));

		User::create(array(
			'email' =>	'user1@user.com',
			'facebookToken'	=>	'12345',
			'facebookActivation' =>	'0',
			'instagramToken'	=>	null,
			'instagramActivation' =>	'0',
			'twitterToken'	=>	'379541294-MFGRKdCeK8BxDSEb6sIsGcWudmtNZjbxQWOaXBQt',
			'twitterSecret' => 'pL5VvIvdamHoJP8OOE60L05faz2EIZBOjIfZnurAiQfXh',
			'twitterActivation' =>	'0',
			'snapchatUsername'	=>	'assymcgee',
			'snapchatActivation' =>	'0',
			'phoneActivation' =>	'0'
		));

		User::create(array(
			'email' =>	'user2@user.com',
			'facebookToken'	=>	'12345',
			'facebookActivation' =>	'0',
			'instagramToken'	=>	'401682282.cdb1435.8ae4572033f949c8bf5ec7642b350054',
			'instagramActivation' =>	'0',
			'twitterToken'	=> null,
			'twitterSecret' => null,
			'twitterActivation' =>	'0',
			'snapchatUsername'	=>	'assymcgee',
			'snapchatPassword' =>	'ggggg',
			'snapchatActivation' =>	'0',
			'phoneActivation' =>	'0'
		));

		User::create(array(
			'email' =>	'user3@user.com',
			'facebookToken'	=>	'12345',
			'facebookActivation' =>	'0',
			'instagramToken'	=>	null,
			'instagramActivation' =>	null,
			'twitterToken'	=> null,
			'twitterSecret' => null,
			'twitterActivation' =>	null,
			'snapchatUsername'	=>	null,
			'snapchatPassword' =>	null,
			'snapchatActivation' =>	null,
			'phoneActivation' =>	null
		));
	}

}
