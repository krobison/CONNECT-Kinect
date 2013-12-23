<?php

class SearchController extends BaseController {
	
	public function showSearch() {
		return View::make('search')
			->with('user', Auth::user());
	}
	
	public function processSearch() {
		$name = Input::get('name');
		$courses = Input::get('classes');
		$courseIds = implode(",", $courses);
		$results = DB::select(
		"SELECT u.* 
		FROM users u
		JOIN course_user l ON u.id = l.user_id
		JOIN courses c ON c.id = l.course_id
		WHERE c.id IN ( '$courseIds' )
		AND ( CONCAT(first, ' ', last) LIKE '%$name%' 
		OR last LIKE '%$name%')"
		);
		
		
		
		
		return View::make('search')->with('results', $results)->with('user', Auth::user());
	}

}