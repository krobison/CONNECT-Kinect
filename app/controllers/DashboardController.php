<?php

class DashboardController extends BaseController {
	
	public function showNewsfeed() {
		return View::make('newsfeed')
			->with('user', Auth::user())
			->with('posts', Post::orderBy('created_at', 'DESC')->get());
	}
	
	public function showProfile() {
		return View::make('profile');
	}
	
	public function showHelpCenter() {
		return View::make('helpCenter');
	}
	
}