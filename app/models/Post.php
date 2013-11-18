<?php

class Post extends Eloquent {

	/**
	 * Automatically uses users table based on naming conventions
	 */
	protected $table = 'posts';

	/**
	 *	Relationships.
	 */
	 
	public function posts() {
		return $this->hasOne('User');
	}
		
	public function comments() {
		return $this->hasMany('Comment');
	}

}