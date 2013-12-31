<?php

class Note extends Eloquent {

	protected $table = 'notes';

	public function conversation() {
		$this->belongsTo('Conversation');
	}
	
	public function user() {
		$this->belongsTo('User');
	}

}