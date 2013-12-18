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
	
	// GET edit profile page
	Route::get('editprofile', 'UserController@editUser');
	
	// GET cs question?
	Route::get('CSQuestion', 'CSQuestionController@showCSQuestion');

	Route::get('questiondetails/{id}', 'CSQuestionController@showQuestionDetails');

	Route::post('createCommentQuestion', 'CSQuestionController@createCommentQuestion');
	
	// GET help center
	Route::get('helpCenter', 'HelpCenterController@showHelp');
	
	// POST help center posts
	Route::post('createhelprequestpost', 'PostController@createHelpRequestPost');
	Route::post('createhelpofferpost', 'PostController@createHelpOfferPost');
	
	// GET search page
	Route::get('search', 'DashboardController@showSearch');
	
	Route::get('searchfilter', 'SearchController@processSearch');
	
	// GET logout and redirect to root
	Route::get('logout', 'UserController@logoutUser');

	Route::get('singlepost/{id}', 'PostController@showSinglePost');

	Route::post('createComment', 'PostController@createComment');

	// POST to update upvotes for a post
	Route::post('upvote', 'PostController@upvote');
	
	Route::post('changedAccount','UserController@changedAccount');
	
	Route::get('badpasswordedit','UserController@badPassword');

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

