<?php

class ProjectsController extends BaseController {
	
	public function showProjects() {
		return View::make('projects')->with('user', Auth::user());
	}
	
	public function createProjectPost() {
		try {
			$post_P = new PostProject;
			$validator = Validator::make(Input::all(), PostProject::$rules);
			if($validator->passes()) {
				$post_P->link = Input::get('link');
				$screenshot = Input::file('screenshot');
					if($screenshot) {
						$extension = $screenshot->getClientOriginalExtension();
						$newFilename = str_random(25) . "." . $extension;
						$destinationPath = base_path() . '/assets/img/csproject_images';
						$uploadSuccess = Input::file('screenshot')->move($destinationPath, $newFilename);
						if($uploadSuccess) {
							$post_P->screenshot = $newFilename;
						}
					}
			} else {
				Log::error("Validation Failure: ".$validator->messages());
				return Redirect::back()->withErrors($validator)->withInput();
			}
			$file = Input::file('file');
				if($file) {
					$extension = $file->getClientOriginalExtension();
					$newFilename = str_random(25) . "." . $extension;
					$destinationPath = base_path() . '/assets/csproject_files';
					$uploadSuccess = Input::file('file')->move($destinationPath, $newFilename);
					if($uploadSuccess) {
						$post_P->file = $newFilename;
					}
				}
		
			$post_P->save();
			
			$post = new Post;
			$post->user_id = Auth::user()->id;
			$post->content = Input::get('content');
			$post_P->post()->save($post);
			
			
		} catch( Exception $e ) {
				return View::make('debug', array('data' => Input::all()));
				//return Redirect::back()->with('message', 'Your post cannot be created at this time, please try again later.');
			}
			
		return Redirect::back()->with('message', 'Your post has been successfully created.');
	}
}