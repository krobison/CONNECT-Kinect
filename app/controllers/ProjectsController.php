<?php

class ProjectsController extends BaseController {
	
	public function showProjects() {
		$user_id['user_id'] = Auth::user()->id;
		Log::info('projects accessed', $user_id);
		return View::make('projects')->with('user', Auth::user());
	}
	
}