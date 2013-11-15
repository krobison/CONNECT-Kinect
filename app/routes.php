<?php

/**
 *	Begin rendering views for CS-CONNECT.
 */
 
Route::get('csLogin', function() {
	return View::make('csLogin');
});

Route::get('csNewUser', function() {
	return View::make('csNewUser');
});

/*For testing the new style to replace the checkboxes*/
Route::get('csTestBox', function() {
	return View::make('csTestBox');
});


/**
 *	LandingController routes.
 *	This controller handles the root page, plus all login related stuff.
 *	That includes signing up and all that shenanigans...yeh.
 */

// GET initial landing page.
Route::get('/', 'LandingController@showLanding');

// POST login requests.
Route::post('login', 'LandingController@loginUser');

// GET logout requests.
Route::get('logout', 'LandingController@logoutUser');

/**
 *	These next two routes to LandingController are for debugging purposes only.
 * 	They should NOT go to production by any means.
 *
 *	However, these are a good example of how using RESTful routes can clean up
 *	our URLs. We are using a GET and POST request to the same URL but executing
 *	completely different code...
 */
 
// GET signup page.
Route::get('signup', 'LandingController@signupUserPage');

// POST signup request.
Route::post('signup', 'LandingController@signupUser');

// DELETE signup request.
Route::delete('deleteUser', 'LandingController@deleteUser');

/**
 *	After being logged in.
 *	Home doesn't have a controller since it is just a static page.
 *	However the People tab and the Profile tab both have distinct controllers.
 */

// All require authentication.
Route::group(array('before' => 'auth'), function() {
	
	// GET home page.
	Route::get('home', function() { return View::make('home'); });
	
	// GET people page.
	Route::get('people', 'PeopleController@showPeople');

	// GET profile page.
	Route::get('profile', 'ProfileController@showProfile');

	// PUT profile request. PUT = UPDATE
	Route::put('profile', 'ProfileController@editProfile');
	
});
