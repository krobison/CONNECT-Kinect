<?php

class Post extends Eloquent {

	/**
	 * Automatically uses users table based on naming conventions
	 */
	protected $table = 'posts';

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