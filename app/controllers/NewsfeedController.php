<?php

class NewsfeedController extends BaseController {
	
	public function showNewsfeed() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "newsfeed accessed";
		$log->save();

		return View::make('newsfeed')
			->with('user', Auth::user())
			->with('posts', Post::orderBy('id', 'DESC')->skip(0)->take(10)->get());
	}

}