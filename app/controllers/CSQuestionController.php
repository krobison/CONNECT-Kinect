<?php

class CSQuestionController extends BaseController {
	
	public function showCSQuestion() {
		return View::make('csQuestion')->with('user', Auth::user());;
	}

}