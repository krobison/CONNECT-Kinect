<?php

class SearchController extends BaseController {
	
	public function showSearch() {
		$user_id['user_id'] = Auth::user()->id;
		Log::info('search accessed', $user_id);
		return View::make('search')
			->with('user', Auth::user());
	}
	
	public function processSearch() {
		$name = mysql_real_escape_string(Input::get('name'));
		$courses = Input::get('classes');
		$nameresults = NULL;
		$bioresults = NULL;
		$searchCourses = "";
		$logText = "";
		if (!empty($name)) {
			$logText = $logText . $name . ", ";
		}
		
		if (empty($courses) && empty($name)) {
			return View::make('search')->with('user', Auth::user());
		
		} elseif(empty($courses)) {
			$nameresults = DB::select(
			"SELECT *
			FROM users
			WHERE CONCAT(first, ' ', last) LIKE '%$name%' OR last LIKE '%$name%'"
			);
			
			$bioresults = DB::select(
			"SELECT *
			FROM users
			WHERE bio LIKE '%$name%'"
			);
			
		} elseif(empty($name)) {
			foreach ($courses as $course) {
				$course = mysql_real_escape_string($course);
			}
			$courseIds = implode(",", $courses);
			$nameresults = DB::select(
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
			
			$searchCourses = DB::table('courses')
				->whereIn('id',$courses)
				->get();
				
		} else {
			foreach ($courses as $course) {
				$course = mysql_real_escape_string($course);
			}
			$courseIds = implode(",", $courses);
			$nameresults = DB::select(
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
			
			$bioresults = DB::select(
			"SELECT u.* 
			FROM users u
			JOIN course_user l ON u.id = l.user_id
			JOIN courses c ON c.id = l.course_id
			WHERE FIND_IN_SET ( c.id, '$courseIds' )
			AND bio LIKE '%$name%'
			GROUP BY u.id
			ORDER BY COUNT(1) DESC"
			);
			
			$searchCourses = DB::table('courses')
				->whereIn('id',$courses)
				->get();
			for ($i = 0; $i < sizeof($searchCourses); $i++) {
				$logText = $logText . " " . $searchCourses[$i]->prefix . " " . $searchCourses[$i]->number . " " . $searchCourses[$i]->name. " , ";
			}
		}

		$user_id['user_id'] = Auth::user()->id;
		Log::info('search made for ' . $logText, $user_id);
		
		return View::make('search')
			->with('nameresults', $nameresults)
			->with('bioresults', $bioresults)
			->with('searchCourses', $searchCourses)
			->with('name', $name)
			->with('user', Auth::user());
	}
	
	public function showAllUsers() {
		return View::make('search')
			->with('user', Auth::user())
			->with('nameresults', DB::table('users')->get());
	}

}