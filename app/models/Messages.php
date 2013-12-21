<?php

class User extends Elequent {
	public function messages() {
		return $this->belongsToMany('Message');
	}

	public function sent_messages()	{
		return $this->hasMany('Messages', 'from');
	}
}

class Message extends Elequent {
	public function from() {
		return $this->belongsTo('User', 'from');
	}

	public function to() {
		return $this->belongsToMany('User');
	}
}