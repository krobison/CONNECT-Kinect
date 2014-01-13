<?php

class CommunityController extends BaseController {
	
	public function showCommunity() {


	 	
	 	/**
	 	 *	Now figure out which page to present.
	 	 */
	
	 	if (Input::has('hashtag')) {
	 		
	 		// get all users
	 		$users = User::with('hashtags')->get();
	 		
	 		// filter users with certain hastag
	 		$users = $users->filter(function ($user) {
	 		
	 			if ($user->hashtags->contains(Input::get('hashtag'))) {
		 			return $user;
	 			}
	 		
	 		});
	 		
	 		// convert
	 		$testing = array();
	 		
	 		foreach($users as $user) {
		 		
		 		$testing2 = array();
		 		
		 		$testing2['id'] = $user->id;
		 		
		 		$testing2['name'] = $user->first . ' ' . $user->last;
		 		$testing2['short_name'] = $user->first . ' ' . $user->last;
		 		
				if ($user->id == Auth::user()->id) {
					$testing2['is_mine'] = true;
				} else {
					$testing2['is_mine'] = false;
				}
		 		
		 		array_push($testing, $testing2);
		 		
	 		}
	 		
	 		$interests = $testing;
	 		
	 		/**
	 		 *	Now load page.
	 		 */ 
	 		 
	 		// get hashtag name
	 		$hashtagName = Hashtag::find(Input::get('hashtag'))->name;
	 	
	 		$encoded_interests = htmlspecialchars(json_encode($interests), ENT_QUOTES);
	
	 		$onLoad = "init(".$encoded_interests.");";
	
	 		return View::make('community')
	 		->with('onLoad', $onLoad)
	 		->with('interests', $interests)
	 		->with('user_view', true)
	 		->with('header', $hashtagName)
	 		->with('user', Auth::user());
	
	 	} else {
	
			/**
			 *	New call to API.
			 */
			
			// get the list of tags
			$tags = json_decode(file_get_contents('http://toilers.mines.edu/csconnect-pchoi/apiTags'));
			
			// convert
			$testing = array();
			
			foreach ($tags as $tag) {
			
				$testing2 = array();
			
			 	// going from stdObject to array
			 	// not casting because we also need short_name
				$testing2['id'] = $tag->id;
				$testing2['name'] = $tag->name;
				$testing2['short_name'] = $tag->name;
			
				array_push($testing, $testing2);
			
			}
			
	 		/**
			 *	Swap result between the APIs.
	    	 */
			$interests = $testing;
	 		
	 		/**
	 		 *	New way of adding is_mine flag.
	  		 */
	 		
	 		$myTags = json_decode(file_get_contents('http://toilers.mines.edu/csconnect-pchoi/myTags'));
	 		
	 		$myTags2 = array();
	 		
	 		foreach ($myTags as $oneOfMyTags) {
	 			array_push($myTags2, $oneOfMyTags);
	 		}
	 		
	 		for ($i = 0; $i < count($interests); $i++) {
	 			$interests[$i]['is_mine'] = in_array($interests[$i]['id'], $myTags2);
	 		}
	 		
	 		/**
	 		 *	Now load page.
	 		 */ 
	 	
	 		$encoded_interests = htmlspecialchars(json_encode($interests), ENT_QUOTES);
	
	 		$onLoad = "init(".$encoded_interests.");";
	
	 		return View::make('community')
	 		->with('onLoad', $onLoad)
	 		->with('interests', $interests)
	 		->with('user_view', false)
	 		->with('header', 'Hashtags')
	 		->with('user', Auth::user());
	
	 	}
	
	}

}