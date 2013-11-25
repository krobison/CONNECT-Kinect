<?php

/**
 *	This controller handles all interactions with users.
 *	As well as CRUD operations, login and logout.
 */

class UserController extends BaseController {

	// Create a new user in the database, with validations
	public function createUser() {
		$validator = Validator::make(Input::all(), User::$rules);
		
		if($validator->passes()) {
		
			//try {
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
			
			// Get the profile picture upload from the file array
			$file = Input::file('profilepic');
			if($file) {
				$oldFilename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension();
				$newFilename = str_random(25) . "." . $extension;
				$destinationPath = base_path().'/assets/img/profile_images';
				$uploadSuccess = Input::file('profilepic')->move($destinationPath, $newFilename);
			}

			// Save the name of the picture to the database
			$user->picture = $newFilename;
			// Write all fields in user to the database
			$user->save();

			return Redirect::to('/')->with('message', 'A new account has been created!');

			//}catch( Exception $e ) {
            //    return Redirect::back()->with('message', 'Login Failed');
			//} 
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}
	
	// Login user and redirect.
	public function loginUser() {
		return Redirect::to('phptest');
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Input::get('password'));
		if (Auth::attempt($userdata)) {
			dd("???");
			return Redirect::to('newsfeed');
		} else {
			return Redirect::to('/')->with('message', 'Login Failed');
		}
	}
	
	// Logout user and redirect.
	public function logoutUser() {
		Auth::logout();
		return Redirect::to('/')->with('message', 'You have successfully been logged out.');
	}
		
}