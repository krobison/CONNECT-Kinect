<?php

include(app_path().'/purify/HTMLPurifier.auto.php');

class Comment extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function post() {
		return $this->belongsTo('Post');
	}
	
	// Helper function
	public function getPurifiedContent() {
		$pureconfig = HTMLPurifier_Config::createDefault();
		$purifier = new HTMLPurifier($pureconfig);
		return $purifier->purify($this->content);
	}
}