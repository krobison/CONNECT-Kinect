<?php

class Post extends Eloquent {

	/**
	 *	Relationships.
	 */
	 
	public function users() {
		return $this->belongsTo('User');
	}
		
	public function comments() {
		return $this->hasMany('Comment');
	}

}