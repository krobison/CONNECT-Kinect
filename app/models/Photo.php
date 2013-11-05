<?php

class Photo extends Eloquent {
	
	// Table in database.
	protected $table = 'photos';
	
	// Allow to be mass assigned.
	protected $fillable = array('path');
	
	// Turn off timestamps.
	public $timestamps = false;

	// Define the relationship to user.
	public function user() {
		return $this->belongsTo('User');
	}
	
}