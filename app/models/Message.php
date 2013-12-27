<?php
class Message extends Eloquent {
	public function fromUser() {
		return $this->belongsTo('User', 'from');
	}

	public function toUser() {
		return $this->belongsTo('User', 'to');
	}
}