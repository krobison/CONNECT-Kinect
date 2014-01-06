<?php

class NewsfeedController extends BaseController {
	
	public function showNewsfeed() {
		$user_id['user_id'] = Auth::user()->id;
		Log::info('newsfeed accessed', $user_id);
		return View::make('newsfeed')
			->with('user', Auth::user())
			->with('posts', Post::orderBy('id', 'DESC')->take(5)->get());
	}

}