<?php

class HelpController extends BaseController {
	
	public function showHelp() {
		return View::make('help');
	}

}