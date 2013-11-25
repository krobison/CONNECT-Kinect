<?php

/**
 *	Routes before being logged in.
 *	This includes root, signing up, and blah.
 */

// GET root, login page
Route::get('/', function() { return View::make('login'); });

// POST login requests
Route::post('/', 'UserController@loginUser');

// GET signup page
Route::get('signup', function() { return View::make('signup'); });

// POST signup request
Route::post('signup', 'UserController@createUser');

/**
 *	Routes after being logged in.
 *	These routes all have a before filter that checks to see if user is logged in.
 */

Route::group(array('before' => 'auth'), function() {

	// GET newsfeed page
	Route::get('newsfeed', 'DashboardController@showNewsfeed');
	
	// GET logout and redirect to root
	Route::get('logout', 'UserController@logoutUser');
	
	Route::get('helpcenter', function() {
	return View::make('helpcenter');
	});

	Route::post('createhelppost', 'PostController@createHelpPost');
	
});

/**
 *	Experimental routes.
 *	Stuff that we are still testing out, and shit.
 */

// stuff that thomas is working on..? ...yeah...derp
Route::get('post', 'PostController@showPost');
Route::post('newuser', 'PostController@addUser');

// For testing the new style to replace the checkboxes
Route::get('csTestBox', function() {
	return View::make('csTestBox');
});

Route::get('phptest', function() { return View::make('phptest'); });

Route::get('csProfile', function() {
	return View::make('csProfile');
});


