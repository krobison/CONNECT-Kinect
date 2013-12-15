<?php

/**
 *	This controller handles all interactions with users.
 *	As well as CRUD operations, login and logout.
 */

class UserController extends BaseController {

	// Create a new user in the database, with validations
	public function createUser() {
		$data = Input::all();	
		$validator = Validator::make(Input::all(), User::$rules);

		if($validator->passes()) {
			try {
				$user = new User;
				
				// Add entries the the database that belong to everyone
				$user->first = Input::get('first');
				$user->last = Input::get('last');
				$user->email = Input::get('email');               
				$user->password = Hash::make(Input::get('password'));
				$user->bio = Input::get('bio');
				
				// Add entries to the database that only belong to students
				if(Input::get("student") == "yes") {
					$user->degree_type = Input::get('degree_type');
					$user->grad_date = Input::get('grad_date');
					$user->major = Input::get('major');
					$user->minor = Input::get('minor');
				}
				
				// Get the profile picture upload from the file array
				$file = Input::file('profilepic');
				if($file) {
					$extension = $file->getClientOriginalExtension();
					$newFilename = str_random(25) . "." . $extension;
					$destinationPath = base_path() . '/assets/img/profile_images';
					$uploadSuccess = Input::file('profilepic')->move($destinationPath, $newFilename);
					if($uploadSuccess) {
						$user->picture = $newFilename;
					}
				}
							
				// Write all fields in user to the database
				$user->save();
				
				// Update classes for the student
				if(Input::get("student") == "yes") {
					$courses = Input::get("classes");
					foreach($courses as $course) {
						$user->courses()->attach($course, array("instructor"=>0)); 
					}
				}
				
				// Update classes for the instructor
				if(Input::get("instructor") == "yes") {
					$courses = Input::get("classes_instructor");
					foreach($courses as $course) {
						$user->courses()->attach($course, array("instructor"=>1)); 
					}
				}
				
				return Redirect::to('/')->with('message', 'A new account has been created! Please try logging in.');
				
			} catch( Exception $e ) {
				Log::error('New User Error: ' . $e);
				return Redirect::back()->with('message', 'Login Failed: '.$e->getMessage());
			}
		} else {
			Log::error("Validation Failure: ".$validator->messages());
			return Redirect::back()->withErrors($validator);
		}
	}
	
	// Login user and redirect.
	public function loginUser() {
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Input::get('password'));
		if (Auth::attempt($userdata)) {
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
	
	public function editUser() {
		return View::make('editProfile')->with('user', Auth::user());
	}

}