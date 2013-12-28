<?php
class Message extends Eloquent {
	public function fromUser() {
		return $this->belongsTo('User', 'from');
	}

	public function toUser() {
		return $this->belongsTo('User', 'to');
	}
}

class User_message extends Eloquent {

	/**
	 * Automatically uses users_messages table based on naming conventions
	 */
	protected $table = 'user_messages';

	public function toUser() {
		return $this->belongsTo('User', 'user_id');
	}
}