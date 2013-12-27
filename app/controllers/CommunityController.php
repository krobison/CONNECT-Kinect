<?php

class CommunityController extends BaseController {
	
	public function showCommunity() {
		return View::make('community')->with('user', Auth::user());
	}
	
}