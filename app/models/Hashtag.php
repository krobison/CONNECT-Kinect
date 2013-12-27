<?php
class Hashtag extends Eloquent {

	/*
	 *	Relationships.
	 */
	 
	public function posts() {
		return $this->hasMany('Post');
	}
	    
}