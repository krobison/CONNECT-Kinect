<?php

class NewsfeedController extends BaseController {
	
	public function showNewsfeed() {
		return View::make('newsfeed')
			->with('user', Auth::user())
			->with('posts', Post::orderBy('id', 'DESC')->take(5)->get());
	}

}