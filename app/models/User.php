<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent {

	/*
	* Instance variables for user
	**/
	private $email;
	private $fbToken;
	private $fbActivation;
	private $instaToken;
	private $instaActivation;
	private $twitterToken;
	private $twitterActivation;
	private $snapName;
	private $snapPass;
	private $snapAct;
	private $phoneAct;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $fillabe = array(
		'email',
		'facebookToken',
		'facebookActivation',
		'instagramToken',
		'instagramActivation',
		'twitterToken',
		'twitterActivation',
		'snapchatUsername',
		'snapchatPassword',
		'snapchatActivation',
		'phoneActivation');
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('snapchatPassword');

	/*

	public function _construct(
		$email = 'email',
		$token = 'token',
		$fbActivation=false,
		$instaToken='instaToken',
		$instaActivation=false,
		$twitterToken='twitterToken',
		$twitterActivation=false,
		$snapName='snapName',
		$snapPass='snapPass',
		$snapAct=false,
		$phoneAct=false
		)
	{
		
		$this->email = $email;
		$this->fbtoken = $token;
		$this->fbActivation=$fbActivation;
		$this->instaToken=$instaToken;
		$this->instaActivation=$instActivation;
		$this->twitterToken=$twitterToken;
		$this->twitterActivation=$twitterActivation;
		$this->snapName=$snapName;
		$this->snapPass=$snapPass;
		$this->snapAct=$snapAct;
		$this->phoneAct=$phoneAct;
		
		//echo 'poop';
	}*/

	public function getStuff()
	{
		echo 'poop';
	}

	public function info()
	{
		return $this->attributes;
	}
}
