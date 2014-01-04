<?php

class ProfileController extends BaseController {
	
	public function showProfile($id) {
		$studentClasses = "";
		$studentTable = DB::table('course_user')
		 	->where('user_id','=',$id)
		 	->where('instructor','=','0');
			$course_ids = $studentTable->lists('course_id');
		if (!empty($course_ids)){
			$studentClasses = DB::table('courses')
				->whereIn('id',$course_ids)
				->get();
		}

		$teacherClasses = "";
		$teacherTable = DB::table('course_user')
		 	->where('user_id','=',$id)
		 	->where('instructor','=','1');
			$course_ids = $teacherTable->lists('course_id');
		if (!empty($course_ids)){
			$teacherClasses = DB::table('courses')
				->whereIn('id',$course_ids)
				->get();
		}

		$userTags = "";
				$tagTable = DB::table('hashtag_user')
		 	->where('user_id','=',$id);
			$tag_ids = $tagTable->lists('hashtag_id');
		if (!empty($tag_ids)){
			$userTags = DB::table('hashtags')
				->whereIn('id',$tag_ids)
				->get();
		}
		
		return View::make('profile')
			->with('user', Auth::user())
			->with('currentuser', User::find($id))
			->with('studentClasses',$studentClasses)
			->with('teacherClasses',$teacherClasses)
			->with('userTags',$userTags)
			->with('posts', 
				Post::orderBy('created_at', 'DESC')
					->where('user_id','=',$id)
					->get()
				);
	}
	
}