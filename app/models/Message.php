<?php
class Message extends Eloquent {
	public function recipients() {
		return $this->belongsToMany('User');
	}

	public function sender() {
		return User::find($this->from);
	}
}