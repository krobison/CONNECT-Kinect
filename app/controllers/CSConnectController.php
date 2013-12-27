<?php

class CSConnectController extends BaseController {
	
	public function showCs_connect() {
		return View::make('cs_connect')->with('user', Auth::user());
	}
	
}