<?php

/**
 *	Primary routes!
 *	These routes are in place for production!
 */

// GET root, login page
Route::get('/', function() { return View::make('login'); });

// POST login requests
Route::post('csSignIn', array(
	'uses' => 'LandingController@csSignInUser',
	'as' => 'csSignIn'
));

// GET signup page
Route::get('signup', function() { return View::make('signup'); });

// POST signup request
Route::post('signup', 'LandingController@csSignUpUser');

// Before accessing these pages, authentication is required.
Route::group(array('before' => 'auth'), function() {

	// GET newsfeed page
	Route::get('newsfeed', function() { return View::make('newsfeed'); });
	
	// GET logout and redirect to root
	Route::get('logout', function() { 
		Auth::logout();
		return Redirect::to('/')->with('message', 'You have successfully been logged out.');
	});
	
});

/**
 *	Experimental routes.
 *	Stuff that we are still testing out, and shit.
 */

// stuff that thomas is working on?
Route::get('post', 'PostController@showPost');
Route::post('newuser', 'PostController@addUser');

// For testing the new style to replace the checkboxes
Route::get('csTestBox', function() {
	return View::make('csTestBox');
});
