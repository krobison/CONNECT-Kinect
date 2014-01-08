<?php

class ProjectsController extends BaseController {
	
	public function showProjects() {
		$user_id['user_id'] = Auth::user()->id;
		Log::info('projects accessed', $user_id);
		$projectposts = DB::table('posts')
						->where('postable_type', '=', 'PostProject')
						->leftJoin('postsProjects', 'posts.postable_id', '=', 'postsProjects.id')
						->where('postsProjects.approved', '=', '1')
						->take(5)
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
		->take(5)
		->select('posts.*')
		->get();
		if(empty($posts)) {
		return;
		}
		return View::make('loadmorespecificposts')
		->with('user', Auth::user())
		->with('posts', $posts);
	}
}