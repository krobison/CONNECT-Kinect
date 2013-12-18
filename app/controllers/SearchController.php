<?php

class SearchController extends BaseController {
	
	public function processSearch() {
		$name = Input::get('name');
		$results = DB::select("SELECT * FROM users WHERE CONCAT(first, ' ', last) LIKE '%$name%' OR last LIKE '%$name%'");
		return View::make('search')->with('results', $results)->with('user', Auth::user());
	}

}