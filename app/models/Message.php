<?php

class Message extends Elequent {
	public function from() {
		return $this->belongsTo('User', 'from');
	}

	public function to() {
		return $this->belongsTo('User', 'to');
	}
}