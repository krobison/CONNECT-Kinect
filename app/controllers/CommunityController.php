<?php

class CommunityController extends BaseController {
	
	public function showCommunity() {
	
		/**
		 *	Community tool by Andrew Suter-Morris.
		 *	Imported to Laravel by Peter Choi.
		 *
		 *	Couple things to note:
		 *		1. Old school PHP did not use objects.
		 *		   So you will see a lot of array iteration for converting.
		 *		2. Input to the JIT is through a variable called 'interests'.
		 *	       It is initialized through a script on body onload.
		 *		3. There are two directedgraph.js files, one for user.
		 *		   There is really not much of a difference between the two,
		 *		   just needed a way to encode a different URL for nodes.
		 *		4. The import was messy, so this code sorta sucks-my bad.
		 */

		/**
		 *	Outer if statement that determines which page to load,
		 *	either the hashtag view or the user view.
		 *
		 *	Initially, the hashtag view is shown (the else portion).
		 */
	 	if (Input::has('hashtag')) {
	 	
	 		/**
	 		 *	Get users with specific hashtag.
	 		 */
	 		
	 		// get all users
	 		$users = User::with('hashtags')->get();
	 		
	 		// filter users with certain hashtag
	 		$users = $users->filter(function ($user) {
	 		
	 			if ($user->hashtags->contains(Input::get('hashtag'))) {
		 			return $user;
	 			}
	 		
	 		});
	 		
	 		// convert
	 		$interests = array();
	 		
	 		foreach($users as $user) {
		 		
		 		$temp = array();
		 		
		 		$temp['id'] = $user->id;
		 		
		 		$temp['name'] = $user->first . ' ' . $user->last;
		 		$temp['short_name'] = $user->first . ' ' . $user->last;
		 		
		 		// add is_mine flag if we are that user
				if ($user->id == Auth::user()->id) {
					$temp['is_mine'] = true;
				} else {
					$temp['is_mine'] = false;
				}
		 		
		 		array_push($interests, $temp);
		 		
	 		}
	 		
	 		/**
	 		 *	Now load page.
	 		 */ 
	 		 
	 		// init code for jit
	 		$encoded_interests = htmlspecialchars(json_encode($interests), ENT_QUOTES);
	 		$onLoad = "init(".$encoded_interests.");";
	 		
	 		// get hashtag name
	 		$hashtagName = Hashtag::find(Input::get('hashtag'))->name;
	
	 		// make page
	 		return View::make('community')
	 			->with('onLoad', $onLoad)
	 			->with('interests', $interests)
	 			->with('user_view', true)
	 			->with('header', $hashtagName)
	 			->with('user', Auth::user());
	
	 	} else {
	 	
	 		/**
	 		 *	Get the tags.
	 		 */
	
			// get the list of tags
			//$tags = Hashtag::all()->orderBy('name', 'desc')->get();
			$tags = DB::table('hashtags')->orderBy('name', 'asc')->get();
			
			// convert
			// going from stdObject to array
			// not casting because we also need short_name
			$interests = array();
			foreach ($tags as $tag) {
			
				$temp = array();
			 	
				$temp['id'] = $tag->id;
				$temp['name'] = $tag->name;
				if (strlen($tag->name) >= 11)
					$temp['short_name'] = substr($tag->name, 0, 10) . "...";
				else
					$temp['short_name'] = $tag->name;
			
				array_push($interests, $temp);
			
			}
	 		
	 		/**
	 		 *	New way of adding is_mine flag.
	  		 */
	 		
	 		$myTags = Auth::user()->hashtags;
	 		
	 		// convert
	 		$myTags2 = array();
	 		foreach ($myTags as $oneOfMyTags) {
	 			array_push($myTags2, $oneOfMyTags->id);
	 		}
	 		
	 		// if it is in there, add is_mine flag
	 		for ($i = 0; $i < count($interests); $i++) {
	 			$interests[$i]['is_mine'] = in_array($interests[$i]['id'], $myTags2);
	 		}
	 		
	 		/**
	 		 *	Now load page.
	 		 */ 
	 	
	 		// init code for jit
	 		$encoded_interests = htmlspecialchars(json_encode($interests), ENT_QUOTES);
	 		$onLoad = "init(".$encoded_interests.");";
	
	 		// make page
	 		return View::make('community')
	 			->with('onLoad', $onLoad)
	 			->with('interests', $interests)
	 			->with('user_view', false)
	 			->with('header', 'Hashtags')
	 			->with('user', Auth::user());
	
	 	}
	
	}

}