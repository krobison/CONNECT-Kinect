<?php

class Conversation extends Eloquent {
	
	protected $table = 'conversations';

	public function users() {
        return $this->belongsToMany('User');
    }
    
    public function notes() {
	    return $this->hasMany('Note');
    }
	
}