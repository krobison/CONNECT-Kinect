<?php

class ProjectsController extends BaseController {
	
	public function showProjects() {
		$log = new CustomLog;	
		$log->user_id = Auth::user()->id;
		$log->event_type = "projects accessed";
		$log->save();

		$projectposts = DB::table('posts')
						->where('postable_type', '=', 'PostProject')
						->leftJoin('postsProjects', 'posts.postable_id', '=', 'postsProjects.id')
						->where('postsProjects.approved', '=', '1')
						->take(4)
						->orderBy('posts.id', 'DESC')
						->select('posts.*')
						->get();
		return View::make('projects')->with('user', Auth::user())->with('projectposts', $projectposts);
	}
	
	public function loadMoreProjects() {
		$lastPostId = Input::get('lastpost');
		$posts =DB::table('posts')
		->where('posts.id', '<', $lastPostId)
		->where('postable_type', '=', 'PostProject')
		->leftJoin('postsProjects', 'posts.postable_id', '=', 'postsProjects.id')
		->where('postsProjects.approved', '=', '1')
		->orderBy('posts.id', 'DESC')
		->take(4)
		->select('posts.*')
		->get();
		if(empty($posts)) {
		return;
		}
		return View::make('loadmoreprojectposts')
		->with('user', Auth::user())
		->with('posts', $posts);
	}
}