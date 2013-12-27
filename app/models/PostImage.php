<?php

class PostImage extends Eloquent {

	public function post() {
		return $this->belongsTo('Post');
	}
	
}