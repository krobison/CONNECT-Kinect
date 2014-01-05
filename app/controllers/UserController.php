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
				$user->bio = Input::get('bio');
				
				//PURIFY
				$pureconfig = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($pureconfig);
				$user->bio = $purifier->purify($user->bio);
				
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
				return Redirect::to('/')->with('message', '<div class="alert alert-success"> A new account has been created! Please try logging in.</div> ');				
				
			} catch( Exception $e ) {
				Log::error('New User Error: ' . $e);
				return Redirect::back()->with('message', 'Login Failed: '.$e->getMessage());
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
		if (Auth::attempt($userdata)) {
			return Redirect::to('newsfeed')->with('newsPage','true');
		} else {
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

					DB::table('users')->where('id',Auth::user()->id)
					->update(array
						('first' => Input::get("first"),
						'last' => Input::get("last"),
						'degree_type' => Input::get("degree"),
						'grad_date' => Input::get("grad"),
						'major' => Input::get("major"),
						'minor' => Input::get("minor"),
						'bio' => $bioclean,
						'password' => Hash::make(Input::get('new'))
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
				}
				
				// Update tags for the user
				$tags = Input::get("hashtags");
				if (!empty($tags)){
					//delete all current course_user records
					DB::table('hashtag_user')->where('user_id','=',$id)->delete();
					foreach($tags as $tag) {
						// Server-side duplicate checking
						if (sizeof(DB::table('hashtag_user')->where('hashtag_id','=',$course)->where('user_id','=',$id)->get() == 0)){
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

				DB::table('users')->where('id',Auth::user()->id)
				->update(array
					('first' => Input::get("first"),
					'last' => Input::get("last"),
					'degree_type' => Input::get("degree"),
					'grad_date' => Input::get("grad"),
					'major' => Input::get("major"),
					'minor' => Input::get("minor"),
					'bio' => $bioclean
				));
				return Redirect::to('profile/'.Auth::user()->id);
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

		Auth::logout();
		DB::table('posts')->where('user_id','=',$id)->delete();
		DB::table('questions')->where('user_id','=',$id)->delete();
		DB::table('upvotes')->where('user_id','=',$id)->delete();
		DB::table('hashtag_user')->where('user_id','=',$id)->delete();
		DB::table('comments')->where('user_id','=',$id)->delete();
		DB::table('course_user')->where('user_id','=',$id)->delete();
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
	
	public function deleteNotification() {
		$t = Input::all(); 
		return $t;
	}
}