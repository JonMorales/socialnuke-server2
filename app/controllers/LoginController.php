<?php
class LoginController extends BaseController 
{
	public function doLogin($email,$fbToken)
	{
		if($user = User::find($email)==true);

		else
		{
			$user = new User($email,$fbToken);
		}

			
	}
}