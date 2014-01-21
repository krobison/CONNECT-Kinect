<?php

/**
 *	This controller handles all interactions with users.
 *	As well as CRUD operations, login and logout.
 */

include(app_path().'/purify/HTMLPurifier.auto.php');

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
				$user->gender = Input::get('gender'); 
				$user->bio = Input::get('bio');
				
				// User Email Preferences
				if(Input::get('email_conversation') == null) {
					$user->email_conversation = false;
				} else {
					$user->email_conversation = true;
				}
				if(Input::get('email_tag') == null) {
					$user->email_tag = false;
				} else {
					$user->email_tag = true;
				}
				if(Input::get('email_comment') == null) {
					$user->email_comment = false;
				} else {
					$user->email_comment = true;
				}
				
				//PURIFY
				$pureconfig = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($pureconfig);
				$user->bio = $purifier->purify($user->bio);
				

				
				// Add entries to the database that only belong to students
				if(Input::get("student") == "yes") {
					$user->degree_type = Input::get('degree_type');
					$user->grad_date = Input::get('grad_date');
					
					$major = Input::get("major") == null ? null : implode(', ',Input::get("major"));
					$minor = Input::get("minor") == null ? null : implode(', ',Input::get("minor"));
				
					$user->major = $major;
					$user->minor = $minor;
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
				
				// Write user tags to the db
				$hashtags = Input::get('hashtags');
				$hashtags = preg_split('/(?<!"),(?!")/',$hashtags[0]);
				foreach($hashtags as $tag) {
					// If the value is not numerical, the tag doesn't exist yet. Add it the the table.
					if(is_numeric($tag)) {
						Hashtag::find($tag)->users()->attach($user);
					} else {
						// Only save tags longer than 3 characters
						if(strlen($tag) > 2) {
							$new_tag = new Hashtag;
							$new_tag->name = $tag;
							$new_tag->save();
							$new_tag->users()->attach($user);
						}
					}
				}
				
				/* No longer tracking classes due to FERPA concerns
				// Update classes for the student
				if(Input::get("student") == "yes") {
					$courses = Input::get("classes");
					if (!is_null($courses)){
						foreach($courses as $course) {
							$user->courses()->attach($course, array("instructor"=>0)); 
						}
					}
				}
				
				// Update classes for the instructor
				if(Input::get("instructor") == "yes") {
					$courses = Input::get("classes_instructor");
					if (!is_null($courses)){
						foreach($courses as $course) {
							$user->courses()->attach($course, array("instructor"=>1)); 
						}
					}
				}
				*/
				// send email
				Mail::send('emails.email_validation', array("receiver" => $user, "key" => Crypt::encrypt($user->email)) , function($message) use ($user) {
						$message->to($user->email, $user->first . " " . $user->last)->subject('CS CONNECT -- Email Validation');
				});
				// redirect home with message
				return Redirect::to('/')->with('message', '<div class="alert alert-info"> A new account has been created and an email has been sent, please check your inbox.</div> ');				
				
			} catch( Exception $e ) {
				Log::error('New User Error: ' . $e . ' ' . $e->getMessage());
				return Redirect::back()->with('message', 'There was an error creating your profile: '.$e->getMessage());
			}
		} else {
			Log::error("Validation Failure: ".$validator->messages());
			return Redirect::back()->withErrors($validator)->withInput();
		}
	}
	
	// Login user and redirect.
	public function loginUser() {
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Input::get('password'));
		
		// attempt to login with data
		if (Auth::attempt($userdata)) {
			// if the email has not been validated
			if (Auth::user()->email_validated == '0') {
				// get email to encrypt
				$email = Auth::user()->email;
				// logout
				Auth::logout();
				// redirect to homepage with a link to send another validation email
				return Redirect::to('/')->with('message', '<div class="alert alert-warning">Email has not been validated. <a href="'. URL::to('sendValidation', array('key' => Crypt::encrypt($email))) .'">Send another validation email?</a></div>');
			} 
			// If the email has been validated, just go to newspage or If a user was trying to get to another page and was redirected to login, go to intended page.
			else {
				return Redirect::Intended('newsfeed');
			}
		} 
		// if login failed
		else {
			return Redirect::to('/')->with('message', '<div class="alert alert-danger">Login Failed: Invalid credentials</div>');
		}
	}
	
	// Logout user and redirect.
	public function logoutUser() {
		Auth::logout();
		return Redirect::to('/')->with('message', '<div class="alert alert-success"> You have successfully been logged out. </div>');
	}
	
	public function editUser() {
		$id = Auth::User()->id;

		$studentClasses = "";
		$studentTable = DB::table('course_user')
		 	->where('user_id','=',$id)
		 	->where('instructor','=','0');
			$course_ids = $studentTable->lists('course_id');
		if (!empty($course_ids)){
			$studentClasses = DB::table('courses')
				->whereIn('id',$course_ids)
				->get();
		}
		
		// Generate some html for a select object in an HTML form
		$studentHTML = array();
		foreach(Course::all() as $course) {
			$notSelected = true;
			foreach($course_ids as $courseTakingId) {
				if($course->id == $courseTakingId) {
					array_push($studentHTML, "<option selected value=".$course->id.">".$course->prefix.$course->number." - ".$course->name."</option>");
					$notSelected = false;
					break;
				}
			}
			if($notSelected) {
				array_push($studentHTML, "<option value=".$course->id.">".$course->prefix.$course->number." - ".$course->name."</option>");
			}
		}

		$teacherClasses = "";
		$teacherTable = DB::table('course_user')
		 	->where('user_id','=',$id)
		 	->where('instructor','=','1');
			$course_ids = $teacherTable->lists('course_id');
		if (!empty($course_ids)){
			$teacherClasses = DB::table('courses')
				->whereIn('id',$course_ids)
				->get();
		}
		
		// Generate some html for a select object in an HTML form
		$teacherHTML = array();
		foreach(Course::all() as $course) {
			$notSelected = true;
			foreach($course_ids as $courseTaughtId) {
				if($course->id == $courseTaughtId) {
					array_push($teacherHTML, "<option selected value=".$course->id.">".$course->prefix.$course->number." - ".$course->name."</option>");
					$notSelected = false;
					break;
				}
			}
			if($notSelected) {
				array_push($teacherHTML, "<option value=".$course->id.">".$course->prefix.$course->number." - ".$course->name."</option>");
			}
		}
		
		// Generate some html for a select object in the HTML form
		$tagHTML = array();
		foreach(Hashtag::all() as $tag) {
			$notSelected = true;
			foreach(Auth::user()->hashtags as $userTags) {
				if($tag->id == $userTags->id) {
					array_push($tagHTML, "<option selected value=".$tag->id.">".$tag->name."</option>");
					$notSelected = false;
					break;
				}
			}
			if($notSelected) {
				array_push($tagHTML, "<option value=".$tag->id.">".$tag->name."</option>");
			}
		}

		return View::make('editProfile')
		->with('user', Auth::user())
		->with('studentClasses',$studentClasses)
		->with('teacherClasses',$teacherClasses)
		->with('tagHTML',$tagHTML)
		->with('studentSelectHTML',$studentHTML)
		->with('teacherSelectHTML',$teacherHTML);
	}
	
	public function changedAccount(){
		$id = Auth::User()->id;
		if (Input::get('old') != ""){
			$validator = Validator::make(Input::all(), User::$editrules);
			if (Hash::check(Input::get('old'),Auth::user()->password)){
				if($validator->passes()) {
					//PURIFY
					$pureconfig = HTMLPurifier_Config::createDefault();
					$purifier = new HTMLPurifier($pureconfig);
					$bioclean = $purifier->purify(Input::get('bio'));

					DB::table('course_user')->where('user_id', '=',$id)->delete();
					
					/* No longer used due to FERPA concerns
					// Update classes for the student
					$courses = Input::get("classesStudent");
					if (!empty($courses)){
						//delete all current course_user records
						DB::table('course_user')->where('user_id','=',$id)->where('instructor','=','0')->delete();
						foreach($courses as $course) {
							if (sizeof(DB::table('course_user')->where('course_id','=',$course)->where('user_id','=',$id)->get() == 0)){
								Auth::user()->courses()->attach($course, array("instructor"=>0)); 
							}
						}
					}
					
					// Update classes for the instructor
					$courses = Input::get("classesTeacher");
					if (!empty($courses)){
						//delete all current course_user records
						DB::table('course_user')->where('user_id','=',$id)->where('instructor','=','1')->delete();
						foreach($courses as $course) {
							if (siezof(DB::table('course_user')->where('course_id','=',$course)->where('user_id','=',$id)->get() == 0)){
								Auth::user()->courses()->attach($course, array("instructor"=>1)); 
							}
						}
					}
					*/
					
					// Update tags for the user
					$tags = Input::get("hashtags");
					if (!empty($tags)){
						//delete all current course_user records
						DB::table('hashtag_user')->where('user_id','=',$id)->delete();
						foreach($tags as $tag) {
							// Server-side duplicate checking
							if (sizeof(DB::table('hashtag_user')->where('hashtag_id','=',$tag)->where('user_id','=',$id)->get() == 0)){
								Auth::user()->hashtags()->attach($tag); 
							}
						}
					}
					
					
					//UPDATE USER
					$file = Input::file('profilepic');
					if($file) {
						if(!is_null(Auth::User()->picture)){
							unlink(base_path().'/assets/img/profile_images/'.Auth::User()->picture);	//delete old picture
						}
						$extension = $file->getClientOriginalExtension();
						$newFilename = str_random(25) . "." . $extension;
						$destinationPath = base_path() . '/assets/img/profile_images';
						$uploadSuccess = Input::file('profilepic')->move($destinationPath, $newFilename);
						if($uploadSuccess) {
							DB::table('users')
            				->where('id', '=', $id)
            				->update(array('picture' => $newFilename));
						}
					}
					
					
					// User Email Preferences
					$email_conversation = Input::get('email_conversation') == null ? false : false;
					$email_tag = Input::get('email_tag') == null ? false : false;
					$email_comment = Input::get('email_comment') == null ? false : false;
					
					$major = Input::get("major") == null ? null : implode(', ',Input::get("major"));
					$minor = Input::get("minor") == null ? null : implode(', ',Input::get("minor"));

					DB::table('users')->where('id',Auth::user()->id)
					->update(array
						('first' => Input::get("first"),
						'last' => Input::get("last"),
						'degree_type' => Input::get("degree_type"),
						'grad_date' => Input::get("grad_date"),
						'major' => $major,
						'minor' => $minor,
						'bio' => $bioclean,
						'password' => Hash::make(Input::get('new')),
						'email_conversation' => $email_conversation,
						'email_tag' => $email_tag,
						'email_comment' => $email_comment
					));
					return Redirect::to('profile/'.Auth::user()->id);
				}
				else{
					return Redirect::back()->withErrors($validator);
				}
			}
			else{
				return Redirect::to('badpasswordedit');
			}
		}else{
			$validator = Validator::make(Input::all(), User::$editrulesnopass);
			if($validator->passes()) {
				//PURIFY
				$pureconfig = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($pureconfig);
				$bioclean = $purifier->purify(Input::get('bio'));

				DB::table('course_user')->where('user_id', '=',$id)->delete();
						
				// Update classes for the student
				/*
				$courses = Input::get("classesStudent");
				if (!empty($courses)){
					//delete all current course_user records
					DB::table('course_user')->where('user_id','=',$id)->where('instructor','=','0')->delete();
					foreach($courses as $course) {
						if (sizeof(DB::table('course_user')->where('course_id','=',$course)->where('user_id','=',$id)->get() == 0)){
							Auth::user()->courses()->attach($course, array("instructor"=>0)); 
						}
					}
				}
			
				
				// Update classes for the instructor
				$courses = Input::get("classesTeacher");
				if (!empty($courses)){
					//delete all current course_user records
					DB::table('course_user')->where('user_id','=',$id)->where('instructor','=','1')->delete();
					foreach($courses as $course) {
						if (sizeof(DB::table('course_user')->where('course_id','=',$course)->where('user_id','=',$id)->get() == 0)){
							Auth::user()->courses()->attach($course, array("instructor"=>1)); 
						}
					}
				}*/
				
				// Update tags for the user
				$tags = Input::get("hashtags");
				if (!empty($tags)){
					//delete all current course_user records
					DB::table('hashtag_user')->where('user_id','=',$id)->delete();
					foreach($tags as $tag) {
						// Server-side duplicate checking
						if (sizeof(DB::table('hashtag_user')->where('hashtag_id','=',$tag)->where('user_id','=',$id)->get() == 0)){
							Auth::user()->hashtags()->attach($tag); 
						}
					}
				}
				

				//UPDATE USER
				$file = Input::file('profilepic');
				if($file) {
					if(!is_null(Auth::User()->picture)){
						unlink(base_path().'/assets/img/profile_images/'.Auth::User()->picture);	//delete old picture
					}
					$extension = $file->getClientOriginalExtension();
					$newFilename = str_random(25) . "." . $extension;
					$destinationPath = base_path() . '/assets/img/profile_images';
					$uploadSuccess = Input::file('profilepic')->move($destinationPath, $newFilename);
					if($uploadSuccess) {
						DB::table('users')
        				->where('id', '=', $id)
        				->update(array('picture' => $newFilename));
					}
				}
				
				// User Email Preferences
				$email_conversation = Input::get('email_conversation') == null ? "0" : "1";
				$email_tag = Input::get('email_tag') == null ? "0" : "1";
				$email_comment = Input::get('email_comment') == null ? "0" : "1";
				
				$major = Input::get("major") == null ? null : implode(', ',Input::get("major"));
				$minor = Input::get("minor") == null ? null : implode(', ',Input::get("minor"));

				DB::table('users')->where('id',Auth::user()->id)
				->update(array
					('first' => Input::get("first"),
					'last' => Input::get("last"),
					'degree_type' => Input::get("degree_type"),
					'grad_date' => Input::get("grad_date"),
					'major' => $major,
					'minor' => $minor,
					'bio' => $bioclean,
					'email_conversation' => $email_conversation,
					'email_tag' => $email_tag,
					'email_comment' => $email_comment
				));
				return Redirect::to('profile/'.Auth::user()->id)->with('<div class="alert alert-danger"> Profile Updated Successfully </div>');
			}
			else{
				return Redirect::back()->withErrors($validator);
			}
		}
	}

	public function deleteaccount(){
		$id = Auth::User()->id;

		if(!is_null(Auth::User()->picture)) {
			unlink(base_path().'/assets/img/profile_images/'.Auth::User()->picture);
		}
		
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "account deleted";
		$log->save();

		Auth::logout();
		DB::table('posts')->where('user_id','=',$id)->delete();
		DB::table('questions')->where('user_id','=',$id)->delete();
		DB::table('upvotes')->where('user_id','=',$id)->delete();
		DB::table('hashtag_user')->where('user_id','=',$id)->delete();
		DB::table('comments')->where('user_id','=',$id)->delete();
		DB::table('course_user')->where('user_id','=',$id)->delete();
		DB::table('conversations')->where('owner','=',$id)->delete();
		DB::table('conversation_user')->where('id','=',$id)->delete();
		DB::table('notifications')->where('user_id','=',$id)->delete();
		DB::table('notifications')->where('initiator_id','=',$id)->delete();
		DB::table('notes')->where('user_id','=',$id)->delete();
		DB::table('users')->where('id','=',$id)->delete();
		
		return Redirect::to('/')->with('message', '<div class="alert alert-success"> You have successfully deleted your account. </div>');
	}
	
	public function badPassword(){
		return View::make('editProfile')->with('user', Auth::user())->with('badPassword','true');
	}
	
	public function showLogin() {
		if(Auth::check()) {
			return Redirect::to('newsfeed');
		}
		return View::make('login');
	}
	
	public function showSignUp() {
		if(Auth::check()) {
			return Redirect::to('newsfeed');
		}
		return View::make('signup');
	}
	
	public function emailUsed() {
		$email = Input::get("email");
		$exists = User::where('email','=',$email)->first();
		if ($exists == null) {
			return json_encode(array("value" => false));
		} else { 
			return json_encode(array("value" => true));
		}
	}
	
	public function deleteNotification() {
	
		$notification = Notification::find(Input::get("data"));
		
		// Make sure users can only delete their own notifications
		if($notification->user->id == Auth::user()->id) {
			$notification->delete();
			return 1;
		} else {
			Log::info("Malicious deletion: User ".$notification->user->id." attempted to delete unauthorized notifications");
			return 0;
		}

		return $notification->user()->id;
	}
	
	public function sendValidation($key) {
		// get email out of key
		try {
			$email = Crypt::decrypt($key);
		} catch (Illuminate\Encryption\DecryptException $e) {
			// in the case they tried a bogus key,
			// redirect to home without any issue.
			return Redirect::to('/');
		}
		
		// get user associated with that email
		$user = User::where('email', $email)->get()->first();
		
		// if the user has already authenticated, let them know
		if ($user->email_validated == '1') {
			return Redirect::to('/')->with('message', '<div class="alert alert-warning">Email has already have been validated, please login.</div>');
		}
		// else shoot off email
		else {
			// send email
			Mail::send('emails.email_validation', array("receiver" => $user, "key" => $key) , function($message) use ($user) {
						$message->to($user->email, $user->first . " " . $user->last)->subject('CS CONNECT -- Email Validation');
					});
			// redirect back home
			return Redirect::to('/')->with('message', '<div class="alert alert-warning">Validation email has been sent, please check your inbox.</div>');
		}
	}
	
	public function validateEmail($key) {
		// get email out of key
		try {
			$email = Crypt::decrypt($key);
		} catch (Illuminate\Encryption\DecryptException $e) {
			// in the case they tried a bogus key,
			// redirect to home without any issue.
			return Redirect::to('/');
		}
		
		// get user associated with that email
		$user = User::where('email', $email)->get()->first();
		
		// if the user has already authenticated, let them know
		if ($user->email_validated == '1') {
			return Redirect::to('/')->with('message', '<div class="alert alert-warning">Email has already have been validated, please login.</div>');
		}
		// else validate and log them in!
		else {
			// change validate variable
			$user->email_validated = '1';
			$user->save();
			
			// log them in
			Auth::login($user);
			
			// redirect to newsfeed with message
			return Redirect::to('newsfeed')->with('message', '<div class="alert alert-success">Your email has been validated, welcome to CS CONNECT!</div>');
		}
	}
	
}