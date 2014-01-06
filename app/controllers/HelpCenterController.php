<?php

class HelpCenterController extends BaseController {
	
	public function showHelpCenter() {
		$user_id['user_id'] = Auth::user()->id;
		Log::info('helpCenter accessed', $user_id);
		return View::make('help')
			->with('user', Auth::user());
	}
	
	public function createHelpRequestPost() {
	
		try {
			// First add a PostHelpRequest to the PostHelpRequest table
			$post_HR = new PostHelpRequest;
			$post_HR->anonymous = Input::get('anonymous');
			$post_HR->save();

			// Then add a Post to the Posts table, associating it with the PostHelpRequest through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post->language = Input::get('language');
			$post->code = Input::get('code');
			$post_HR->post()->save($post);
			
		} catch( Exception $e ) {
			return View::make('debug', array('data' => Input::all()));
			//return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		$user_id['user_id'] = Auth::user()->id;
		Log::info('help request post', $user_id);
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	
	public function createHelpOfferPost() {
	
		try {
			// First add a PostHelpOffer to the PostHelpOffertable
			$post_HO = new PostHelpOffer;
			$post_HO->availability = Input::get('availability');
			$post_HO->save();

			// Then add a Post to the Posts table, associating it with the PostHelpRequest through a polymorphic relationship
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post_HO->post()->save($post);
			
		} catch( Exception $e ) {
			return View::make('debug', array('data' => Input::all()));
		//	return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
		}
		
		$user_id['user_id'] = Auth::user()->id;
		Log::info('help offer post', $user_id);
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	public function loadMoreRequests() {
		$lastPostId = Input::get('lastpost');
		$posts = DB::table('posts')
		->where('id', '<', $lastPostId)
		->where('postable_type', '=', 'PostHelpRequest')
		->orderBy('id', 'DESC')
		->take(5)
		->get();
		if(empty($posts)) {
		return;
		}
		return View::make('loadmorespecificposts')
		->with('user', Auth::user())
		->with('posts', $posts)
		->with('type', 'HelpRequestPost');
	}
	
	public function loadMoreOffers() {
		$lastPostId = Input::get('lastpost');
		$posts =DB::table('posts')
		->where('id', '<', $lastPostId)
		->where('postable_type', '=', 'PostHelpOffer')
		->orderBy('id', 'DESC')
		->take(5)
		->get();
		if(empty($posts)) {
		return;
		}
		return View::make('loadmorespecificposts')
		->with('user', Auth::user())
		->with('posts', $posts)
		->with('type', 'HelpOfferPost');
	}
	
}