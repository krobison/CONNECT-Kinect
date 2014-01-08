<?php

class HelpCenterController extends BaseController {
	
	public function showHelpCenter() {
		$user_id['user_id'] = Auth::user()->id;
		Log::info('helpCenter accessed', $user_id);
		return View::make('help')
			->with('user', Auth::user());
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