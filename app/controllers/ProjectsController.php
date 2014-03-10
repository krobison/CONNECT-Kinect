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
						->orderBy('posts.upvotes', 'DESC')
						->skip(0)
						->take(12)
						->select('posts.*')
						->get();
		return View::make('projects')->with('user', Auth::user())->with('projectposts', $projectposts);
	}
	
	public function loadMoreProjects() {
		$toLoad = Input::get('toLoad');
		$orderBy = Input::get('orderBy');
		$toSkip = Input::get('lastpost');
		$posts =DB::table('posts')
		->where('postable_type', '=', 'PostProject')
		->leftJoin('postsProjects', 'posts.postable_id', '=', 'postsProjects.id')
		->where('postsProjects.approved', '=', '1')
		->orderBy('posts.'.$orderBy, 'DESC')
		->skip($toSkip)
		->take($toLoad)
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