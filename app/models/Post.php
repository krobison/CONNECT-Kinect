<?php

class Post extends Eloquent {

	/**
	 *	Relationships.
	 */
	 
	public function user() {
		return $this->belongsTo('User');
	}
		
	public function comments() {
		return $this->hasMany('Comment');
	}

}