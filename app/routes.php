<?php

/**
 *	Routes before being logged in.
 *	This includes root, signing up, and blah.
 */

// GET root, login page
Route::get('/', function() { return View::make('login'); });

// POST login requests
Route::post('loginuser', 'UserController@loginUser');

// GET signup page
Route::get('signup', function() { return View::make('signup'); });

// POST signup request
Route::post('signup', 'UserController@createUser');

// GET request for CSQuestion
Route::get('CSQuestion', 'CSQuestionController@showCSQuestion');

/**
 *	Routes after being logged in.
 *	These routes all have a before filter that checks to see if user is logged in.
 */

Route::group(array('before' => 'auth'), function() {

	// GET newsfeed page
	Route::get('newsfeed', 'DashboardController@showNewsfeed');
	
	// GET profile
	Route::get('profile/{id}', 'DashboardController@showProfile');
	
	// GET cs question?
	Route::get('CSQuestion', 'CSQuestionController@showCSQuestion');
	
	// GET help center
	Route::get('helpCenter', 'HelpCenterController@showHelp');
	
	// POST help center posts
	Route::post('createhelppost', 'PostController@createHelpPost');
	
	// GET logout and redirect to root
	Route::get('logout', 'UserController@logoutUser');

	Route::get('singlepost/{id}', 'PostController@showSinglePost');

	Route::post('createComment', 'PostController@createComment');

});

/**
 *	Experimental routes.
 *	Stuff that we are still testing out, and shit.
 */

// For testing the new style to replace the checkboxes
Route::get('csTestBox', function() {
	return View::make('csTestBox');
});

Route::get('phptest', function() { return View::make('phptest'); });

