<?php

class Role extends Eloquent {
	
	/**
	 *	This line is simply added for clarity.
	 *	Eloquent automatically assumes that the table for the model
	 *	is the lowercase, plural of the model name.
	 */
	protected $table = 'roles';
	
	/**
	 *	Relationship to User.
	 */
	
	public function users() {
		return $this->belongsToMany('User');
	}
	
}