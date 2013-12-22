<?php

class ProjectsController extends BaseController {
	
	public function showProjects() {
		return View::make('projects')->with('user', Auth::user());
	}

}