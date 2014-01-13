<?php

class CSConnectController extends BaseController {
	
	public function showCs_connect() {
		$posts = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostFeedback')->get();

		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "cs_connect accessed";
		$log->save();

		return View::make('cs_connect')
			->with('user', Auth::user())
			->with('posts', $posts);
	}
	
}