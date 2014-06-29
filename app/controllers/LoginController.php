<?php
class LoginController extends BaseController 
{
	public function makeLogin()
	{
		return View::make('FBlogin-test');
	}

	public function doLogin($user)
	{
		echo $user;			
	}
}