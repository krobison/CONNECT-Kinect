<?php

class Course extends Eloquent {

	/**
	 *	Relationships.
	 */
	
	public function users() {
		return $this->belongsToMany('User');
	}
	
}