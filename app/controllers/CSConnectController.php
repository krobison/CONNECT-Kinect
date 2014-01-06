<?php

class CSConnectController extends BaseController {
	
	public function showCs_connect() {
		$posts = Post::orderBy('created_at', 'DESC')->where('postable_type', '=', 'PostFeedback')->get();
		$user_id['user_id'] = Auth::user()->id;
		Log::info('cs_connect accessed', $user_id);
		return View::make('cs_connect')
			->with('user', Auth::user())
			->with('posts', $posts);
	}
	
}