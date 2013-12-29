<?php
class Hashtag extends Eloquent {

	/*
	 *	Relationships.
	 */
	 
	public function posts() {
		return $this->belongsToMany('Post');
	}
	    
}