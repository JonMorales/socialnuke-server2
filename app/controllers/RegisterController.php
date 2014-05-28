<?php

class RegisterController extends BaseController {

	//create registration form
	public function showRegistration()
	{
		return View::make('registration');
	}

	//processes form, making sure that each field is filled in
	public function doRegistration()
	{

		//the rules that the form must comform to
		$rules = array(
		'name' => 'required|min:2',
		'username' => 'required|min:2|unique:users',
		'email' => 'required|email|unique:users',
		'password' => 'required|alphaNum|min:3'
		);

		//runs the validation against all info put in forms
		$validator = Validator::make(Input::all(), $rules);

		//if no erros, fills in database and sends user to 'correct' page
		if($validator->passes())
		{
			$data = Input::all();
			$user = new user;
			$user->name = $data['name'];
			$user->username = $data['username'];
			$user->email = $data['email'];
			$user->password = Hash::make($data['password']);
			$user->save();	

			return View::make('settings'); 
		}

		//if there are errors, returns user to the registration page with forms still filled in (except for the password form)
		else 
		{
			return Redirect::to('registration')
				->withErrors($validator) 
				->withInput(Input::except('password'));
		}
	}
}