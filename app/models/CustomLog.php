<?php

class CustomLog extends Eloquent {

	/*
	 *	Relationships.
	 */
	 
	public function user() {
		return $this->belongsTo('User');
	}
}