<?php

class HelpCenterController extends BaseController {
	
	public function showHelp() {
		return View::make('help')->with('user', Auth::user());;
	}

}