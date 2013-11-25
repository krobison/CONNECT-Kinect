<?php

class DashboardController extends BaseController {
	
	public function showNewsfeed() {
		return View::make('newsfeed')
			->with('user', Auth::user());
	}
	
}