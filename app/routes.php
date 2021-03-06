<?php

/**
 *	Routes before being logged in.
 *	This includes root, signing up, and blah.
 */

// GET root, login page
Route::get('/', 'UserController@showLogin');

// POST login requests
Route::post('loginuser', 'UserController@loginUser');

// GET signup page
Route::get('signup', 'UserController@showSignUp');

// POST signup request
Route::post('signup', 'UserController@createUser');

// GET send validation
Route::get('sendValidation/{key}', 'UserController@sendValidation');

// GET validate email
Route::get('validate/{key}', 'UserController@validateEmail');

// POST validate email AJAX
Route::post('emailUsed', 'UserController@emailUsed');

/**
 *	Routes after being logged in.
 *	These routes all have a before filter that checks to see if user is logged in.
 */

Route::group(array('before' => 'auth'), function() {

	// GET user
	Route::post('changedAccount','UserController@changedAccount');
	Route::get('badpasswordedit','UserController@badPassword');
	Route::get('logout', 'UserController@logoutUser');
	Route::get('editprofile', 'UserController@editUser');
	Route::post('deleteaccount','UserController@deleteaccount');
	
	// GET profile
	Route::get('profile/{id}', 'ProfileController@showProfile');
	Route::post('loadmoreuserposts', 'ProfileController@loadMorePosts');
	
	// GET CS CONNECT
	Route::get('cs_connect', 'CSConnectController@showCs_connect');
	
	// GET newsfeed page
	Route::get('newsfeed', 'NewsfeedController@showNewsfeed');
	
	// GET cs question?
	Route::get('CSQuestion', 'CSQuestionController@showCSQuestion');
	Route::get('showPreviousQuestions', 'CSQuestionController@showPreviousQuestions');
	
	// GET cs kinect
	Route::get('kinect', 'Kinectcontroller@showProjects');
	Route::post('votegames', 'Kinectcontroller@showGames');
	
	// GET cs projects
	Route::get('projects', 'ProjectsController@showProjects');
	Route::post('createprojectpost', 'PostController@createProjectPost');
	Route::post('loadmoreprojects', 'ProjectsController@loadMoreProjects');

	// GET help center
	Route::get('helpCenter', 'HelpCenterController@showHelpCenter');

	// POST help center posts
	Route::post('createhelprequestpost', 'PostController@createHelpRequestPost');
	Route::post('createhelpofferpost', 'PostController@createHelpOfferPost');
	Route::post('loadmorerequests', 'HelpCenterController@loadMoreRequests');
	Route::post('loadmoreoffers', 'HelpCenterController@loadMoreOffers');
	
	// GET community
	Route::get('community', 'CommunityController@showCommunity');
	
	// GET search page
	Route::get('search', 'SearchController@showSearch');
	Route::get('searchfilter', 'SearchController@processSearch');
	Route::get('showallusers', 'SearchController@showAllUsers');
	Route::post('loadmorenameresults', 'SearchController@loadMoreNames');
	Route::post('loadmorebioresults', 'SearchController@loadMoreBios');
	
	// GET post
	Route::get('singlepost/{id}', 'PostController@showSinglePost');
	Route::get('searchposts', 'PostController@searchPosts');
	
	// POST post
	Route::post('createComment', 'PostController@createComment');
	Route::post('upvoteCommentAJAX', 'PostController@upvoteCommentAJAX');
	Route::post('upvote', 'PostController@upvotePost');
	Route::post('upvotePostAJAX', 'PostController@upvotePostAJAX');
	Route::post('creategeneralpost', 'PostController@createGeneralPost');
	Route::post('deleteusercomment', 'PostController@deleteUserComment');
	Route::post('saveeditcomment', 'PostController@saveEditComment');
	Route::post('saveeditpost', 'PostController@saveEditPost');
	Route::post('giveFeedback', 'PostController@giveFeedback');
	Route::post('loadmoreposts', 'PostController@loadMorePosts');

	// GET Ajax NotificationDelete
	Route::post('deleteNotification', 'UserController@deleteNotification');
	
	 // GET conversations
    Route::get('conversations', 'ConversationController@showConversations');
    Route::get('composeConversation', 'ConversationController@composeConversation');
    Route::get('messageUser/{id}', 'ConversationController@messageUser');
    Route::get('showConversation/{id}', 'ConversationController@showConversation');
    Route::get('leaveConversation/{id}', 'ConversationController@leaveConversation');
    Route::get('removeUser/{userId}/{conversationId}', 'ConversationController@removeUser');
    Route::get('addUsers/{conversationId}', 'ConversationController@addUsers');
    // POST conversations
    Route::post('createConversation', 'ConversationController@createConversation');
    Route::post('addToConversation', 'ConversationController@addToConversation');

});


/**
 *	Routes for users with admin privileges
 *	These routes all have a before filter that checks to see if user is logged in and is an admin
 */
 
	//deletes an individual post
	Route::post('deletepost', 'AdminController@deletePost');

Route::group(array('before' => 'auth|admin'), function () {
	//deletes a user's account
	Route::post('deleteuser', 'AdminController@deleteUser');
	
	//deletes an individual comment
	Route::post('deletecomment', 'AdminController@deleteComment');
	
	//approves a cs project
	Route::post('approveproject', 'AdminController@approveProject');
	
	//psot new cs Questions
	Route::post('createcsquestionpost', 'AdminController@createCSQuestion');
	
	//Show the admin tools page
	Route::get('admin','AdminController@showAdminPage');
	
	//Send Admin Emails
	Route::post('sendEmails','AdminController@sendEmails');
});

//PASSWORD REMINDER
	Route::get('password/reset', array(
  		'uses' => 'PasswordController@remind',
  		'as' => 'password.remind'
	));
	Route::post('password/reset', array(
  		'uses' => 'PasswordController@request',
  		'as' => 'password.request'
	));
	Route::get('password/reset/{token}', array(
		'uses' => 'PasswordController@reset',
		'as' => 'password.reset'
	));
	Route::post('password/reset/{token}', array(
		'uses' => 'PasswordController@update',
	 	'as' => 'password.update'
	));

/**
 *	Experimental routes.
 *	Stuff that we are still testing out, and shit.
 */

// For testing the new style to replace the checkboxes
Route::get('csTestBox', function() {
	return View::make('csTestBox');
});

Route::get('phptest', function() { return View::make('phptest'); });

