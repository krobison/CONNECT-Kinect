<?php

class DashboardController extends BaseController {
	
	public function showNewsfeed() {
		return View::make('newsfeed')
			->with('user', Auth::user())
			->with('posts', Post::orderBy('created_at', 'DESC')->get());
	}
	
	public function showProfile($id) {
		return View::make('profile')
			->with('user', Auth::user())
			->with('currentuser', User::find($id));
	}
	
	public function showHelpCenter() {
		return View::make('help')
			->with('user', Auth::user());
	}

}