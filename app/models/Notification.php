<?php
class Notification extends Eloquent {

	/*
	 *	Relationships.
	 */
	 
	public function user() {
		return $this->belongsTo('User');
	}
	
	public function initiator() {
		return $this->hasOne('User');
	}
	    
}