<?php
class Hashtag extends Eloquent {

	/*
	 *	Relationships.
	 */
	 
	public function posts() {
		return $this->belongsToMany('Post');
	}
	
	public function users() {
		return $this->belongsToMany('User');
	}
	
	public function addTagIfValid($tag) {

	}
	    
}