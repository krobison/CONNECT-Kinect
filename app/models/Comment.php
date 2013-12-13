<?php

class Comment extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function post() {
		return $this->belongsTo('Post');
	}
}