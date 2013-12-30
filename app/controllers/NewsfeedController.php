<?php

class NewsfeedController extends BaseController {
	
	public function showNewsfeed() {
		return View::make('newsfeed')
			->with('user', Auth::user())
			->with('posts', Post::orderBy('created_at', 'DESC')->get());
	}
		
	public function createGeneralPost() {
		
		try {
			// Create A Post in the db
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post->save();
			
			// Add an entry in post_hashtag table to save post tags
			$hashtags = Input::get('hashtags');
			foreach($hashtags as $tag) {
				Hashtag::find($tag)->posts()->attach($post);
			}
		} catch( Exception $e ) {
			//return View::make('debug', array('data' => Input::all()));
			return Redirect::back()->with('message', '<div class="alert alert-danger" > Your post cannot be created at this time, please try again later. </div>');
		}
		return Redirect::back();
		//return Redirect::back()->with('message', '<div class="alert alert-success"> Your post has been successfully created. </div>');
	}
	
	
}