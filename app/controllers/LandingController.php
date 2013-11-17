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
			//$user->email = Input::get('email');               no email yet in database
			$user->password = Hash::make(Input::get('password'));
			$user->instructor = '0';
			$user->degree_type = Input::get('degree_type');
			$user->grad_date = Input::get('grad_date');
			$user->major = Input::get('major');
			$user->minor = Input::get('minor');
			$user->bio = Input::get('bio');
			$user->save();
			return Redirect::to('csLogin');
			
			}catch( Exception $e ) {
                return Redirect::back()->with('message', 'Login Failed');
			} 
		} else {
			return Redirect::back()->withErrors($validator);
		}
	}
	
	public function showLanding() {
			// If the user is already logged in,
			// redirect them to the profile page.
			if (Auth::check()) {
				return Redirect::to('home');
			}
			// Else render landing page for login.
			return View::make('landing');
	}
	
	public function loginUser() {
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Input::get('password'));
		if (Auth::attempt($userdata)) {
			return Redirect::to('profile');
		} else {
			return Redirect::to('/')
				->with('message', 'Login combination not found, please try again.');
		}
	}
	
	public function logoutUser() {
		Auth::logout();
		return Redirect::to('/');
	}
	
	public function deleteUser() {
		// Log the user out.
		Auth::logout();
		
		// Get user.
		$user = User::find(Input::get('id'));
			
		// Delete relations.
		$user->roles()->sync(array());
		$user->interests()->sync(array());
		
		// Delete photo.
		$profileImagesDirectory = base_path().'/img/profile_images';
		if ($user->photo) {
			// Delete the photo.
			File::delete($profileImagesDirectory.'/'.$user->photo->path);
			// Delete the relationship.
			$user->photo->delete();
		}
		
		// Delete the user.
		$user->delete();
		
		// Redirect to root.
		return Redirect::to('/')
			->with('message', 'You have been removed from the CONNECT system.');
	}
	
	/**
	 *	Debugging routes only.
	 */
	 
	public function signupUserPage() {
		echo '<h1>Sign Up Page</h1>';
		echo '<form method="POST" action="' . URL::to('signup') . '">';
		echo '<p><input type="text" id="email" name="email" placeholder="Email"></p>';
		echo '<p><input type="text" id="first_name" name="first_name" placeholder="First Name">';
		echo '<p><input type="text" id="last_name" name="last_name" placeholder="Last Name" </p>';
		echo '<p><input type="password" id="password" name="password" placeholder="Password"></p>';
		echo '<p><input type="submit" value="signup">';
		echo '</form>';
	}
	
	public function signupUser() {
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password')),
			'first_name' => Input::get('first_name'),
			'last_name' => Input::get('last_name'));
		$user = new User($userdata);
		$user->save();
		// Yo...that database interaction...soo niiice...
		// No validations handled here though, hence debugging only.

		return Redirect::to('/');
	}
	
}