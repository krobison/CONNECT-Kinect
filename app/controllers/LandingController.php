<?php

/**
 *	This controller handles the landing page,
 *	POST login requests, and logout requests.
 */

class LandingController extends BaseController {

	public function csSignUpUser() {
		$validator = Validator::make(Input::all(), User::$rules);
		
		if($validator->passes()) {
			try {
			$user = new User;
			$user->first = Input::get('first');
			$user->last = Input::get('last');
			$user->email = Input::get('email');               
			$user->password = Hash::make(Input::get('password'));
			$user->instructor = '0';
			$user->degree_type = Input::get('degree_type');
			$user->grad_date = Input::get('grad_date');
			$user->major = Input::get('major');
			$user->minor = Input::get('minor');
			$user->bio = Input::get('bio');
			$user->save();
			return Redirect::to('/')->with('message', 'A new account has been created!');
			
			}catch( Exception $e ) {
                return Redirect::back()->with('message', 'Login Failed');
			} 
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}
	
	public function csSignInUser() {
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Input::get('password'));
		if (Auth::attempt($userdata)) {
			return Redirect::to('newsfeed');
		} else {
			return Redirect::to('/');
		}
	}
		
}