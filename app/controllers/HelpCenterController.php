<?php

class HelpCenterController extends BaseController {
	
	public function showHelpCenter() {
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
		
		// Make the specific post data (e.g., helpPost, project, etc...)
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
	
}