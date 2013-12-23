<?php

class SearchController extends BaseController {
	
	public function showSearch() {
		return View::make('search')
			->with('user', Auth::user());
	}
	
	public function processSearch() {
		$name = Input::get('name');
		$courses = Input::get('classes');
		$results = "";
		$coursess = "";
		if (empty($courses) && empty($name)) {
			return View::make('search')->with('user', Auth::user());
		
		} elseif(empty($courses)) {
			$results = DB::select(
			"SELECT *
			FROM users
			WHERE CONCAT(first, ' ', last) LIKE '%$name%' OR last LIKE '%$name%'"
			);
			
		} else {
			$courseIds = implode(",", $courses);
			$results = DB::select(
			"SELECT u.* 
			FROM users u
			JOIN course_user l ON u.id = l.user_id
			JOIN courses c ON c.id = l.course_id
			WHERE FIND_IN_SET ( c.id, '$courseIds' )
			AND ( CONCAT(u.first, ' ',u.last) LIKE '%$name%' 
			OR last LIKE '%$name%')
			GROUP BY u.id
			ORDER BY COUNT(1) DESC"
			);
			
			$coursess = DB::table('courses')
				->whereIn('id',$courses)
				->get();
		}
		
		return View::make('search')
			->with('results', $results)
			->with('courses', $coursess)
			->with('name', $name)
			->with('user', Auth::user());
	}

}