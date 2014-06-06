<?php

class Note extends Eloquent {

	protected $table = 'notes';

	public function conversation() {
		return $this->belongsTo('Conversation');
	}
	
	public function user() {
		return $this->belongsTo('User');
	}

}