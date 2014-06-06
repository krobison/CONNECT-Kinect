<?php

class SearchController extends BaseController {
	
	public function showSearch() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "search accessed";
		$log->save();

		return View::make('search')
			->with('user', Auth::user());
	}
	
	public function processSearch() {
		$name = mysql_real_escape_string(Input::get('name'));
		$hashtags = Input::get('hashtags');
		$nameresults = NULL;
		$bioresults = NULL;
		$searchHashtags = "";
		$logText = "";
		if (!empty($name)) {
			$logText = $logText . $name . ", ";
		}
		
		// if (empty($courses) && empty($name)) {
		// 	return View::make('search')->with('user', Auth::user());
		
		// } elseif(empty($courses)) {
		// 	$nameresults = DB::select(
		// 	"SELECT *
		// 	FROM users
		// 	WHERE CONCAT(first, ' ', last) LIKE '%$name%' OR last LIKE '%$name%'"
		// 	);
			
		// 	$bioresults = DB::select(
		// 	"SELECT *
		// 	FROM users
		// 	WHERE bio LIKE '%$name%'"
		// 	);
			
		// } elseif(empty($name)) {
		// 	foreach ($courses as $course) {
		// 		$course = mysql_real_escape_string($course);
		// 	}
		// 	$courseIds = implode(",", $courses);
		// 	$nameresults = DB::select(
		// 	"SELECT u.* 
		// 	FROM users u
		// 	JOIN course_user l ON u.id = l.user_id
		// 	JOIN courses c ON c.id = l.course_id
		// 	WHERE FIND_IN_SET ( c.id, '$courseIds' )
		// 	AND ( CONCAT(u.first, ' ',u.last) LIKE '%$name%' 
		// 	OR last LIKE '%$name%')
		// 	GROUP BY u.id
		// 	ORDER BY COUNT(1) DESC"
		// 	);
			
		// 	$searchCourses = DB::table('courses')
		// 		->whereIn('id',$courses)
		// 		->get();
				
		// } else {
		// 	foreach ($courses as $course) {
		// 		$course = mysql_real_escape_string($course);
		// 	}
		// 	$courseIds = implode(",", $courses);
		// 	$nameresults = DB::select(
		// 	"SELECT u.* 
		// 	FROM users u
		// 	JOIN course_user l ON u.id = l.user_id
		// 	JOIN courses c ON c.id = l.course_id
		// 	WHERE FIND_IN_SET ( c.id, '$courseIds' )
		// 	AND ( CONCAT(u.first, ' ',u.last) LIKE '%$name%' 
		// 	OR last LIKE '%$name%')
		// 	GROUP BY u.id
		// 	ORDER BY COUNT(1) DESC"
		// 	);
			
		// 	$bioresults = DB::select(
		// 	"SELECT u.* 
		// 	FROM users u
		// 	JOIN course_user l ON u.id = l.user_id
		// 	JOIN courses c ON c.id = l.course_id
		// 	WHERE FIND_IN_SET ( c.id, '$courseIds' )
		// 	AND bio LIKE '%$name%'
		// 	GROUP BY u.id
		// 	ORDER BY COUNT(1) DESC"
		// 	);	
		// 	$searchCourses = DB::table('courses')
		// 		->whereIn('id',$courses)
		// 		->get();
		// 	for ($i = 0; $i < sizeof($searchCourses); $i++) {
		// 		$logText = $logText . " " . $searchCourses[$i]->prefix . " " . $searchCourses[$i]->number . " " . $searchCourses[$i]->name. " , ";
		// 	}
		// }

		$query1 = DB::table('users');
		$query2 = DB::table('users');

 		if (empty($hashtags) && empty($name)) {
		 	return View::make('search')->with('user', Auth::user());
		
		} 

		if(!empty($hashtags)) {
			$query1->leftJoin('hashtag_user', 'users.id', '=', 'hashtag_user.user_id')->whereIn('hashtag_user.hashtag_id', $hashtags);
			$query2->leftJoin('hashtag_user', 'users.id', '=', 'hashtag_user.user_id')->whereIn('hashtag_user.hashtag_id', $hashtags);
			$searchHashtags = DB::table('hashtags')
							->whereIn('id',$hashtags)
							->get();
		}

		if(!empty($name)) {
			$query1->where(DB::raw("CONCAT(users.first, ' ', users.last) LIKE '%$name%' OR users.last LIKE '%$name%'"));
			$query2->where('users.bio', 'LIKE', "%$name%");
		} 

		$nameresults = $query1->orderBy('users.last', 'asc')->skip(0)->take(10)->select('users.*')->get();
		if(!empty($name)) {
			$bioresults = $query2->orderBy('users.last', 'asc')->skip(0)->take(10)->select('users.*')->get();
		}

		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "search made";
		$log->additional_info = $logText;
		$log->save();
		
		return View::make('search')
			->with('nameresults', $nameresults)
			->with('bioresults', $bioresults)
			->with('searchHashtags', $searchHashtags)
			->with('name', $name)
			->with('user', Auth::user());
	}
	
	public function showAllUsers() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "search made";
		$log->additional_info = "Show all users";
		$log->save();
		return View::make('search')
			->with('user', Auth::user())
			->with('nameresults', DB::table('users')->orderBy('last', 'asc')->skip(0)->take(20)->get());
	}

	public function loadMoreNames() {
		$toLoad = Input::get('toLoad');
		$toSkip = Input::get('lastpost');
		$hashtags = Input::get('hashtags');
		$name = mysql_real_escape_string(Input::get('name'));

		$query = DB::table('users');

		if(!empty($hashtags)) {
			$query->leftJoin('hashtag_user', 'users.id', '=', 'hashtag_user.user_id')->whereIn('hashtag_user.hashtag_id', $hashtags);
		}
		if(!empty($name)) {
			$query->where(DB::raw("CONCAT(first, ' ', last) LIKE '%$name%' OR last LIKE '%$name%'"));
		}

		$nameresults = $query->orderBy('last', 'asc')->skip($toSkip)->take($toLoad)->select('users.*')->get();

		return View::make('loadmoreusers')
		->with('user', Auth::user())
		->with('results', $nameresults)
		->with('type', 'name');
	}

	public function loadMoreBios() {
		$toLoad = Input::get('toLoad');
		$toSkip = Input::get('lastpost');
		$hashtags = Input::get('hashtags');
		$name =  mysql_real_escape_string(Input::get('name'));


		$query = DB::table('users');

		if(!empty($name)) {
			$query->where('bio', 'LIKE', "%$name%");
		}
		if(!empty($hashtags)) {
			$query->leftJoin('hashtag_user', 'users.id', '=', 'hashtag_user.user_id')->whereIn('hashtag_user.hashtag_id', $hashtags);
		}

		$bioresults = $query->orderBy('last', 'asc')->skip($toSkip)->take($toLoad)->select('users.*')->get();

		return View::make('loadmoreusers')
		->with('user', Auth::user())
		->with('results', $bioresults)
		->with('type', 'bio');
	}

}