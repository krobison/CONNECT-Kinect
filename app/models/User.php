<?php

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * Automatically uses users table based on naming conventions
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 *	Relationships.
	 */
	
	public function courses() {
		return $this->belongsToMany('Course');
	}
	
	public function hashtags() {
		return $this->belongsToMany('Hashtag');
	}
	
	public function posts() {
		return $this->hasMany('Post');
	}
	
	public function comments() {
		return $this->hasMany('Comment');
	}
	
	/**
	 *	Validation rules.
	 */
	 
	public static $rules = array(
		'first' => 'required|alpha|max:20',
		'last' => 'required|alpha|max:20',
		'email' => 'required|email',
		'password' => 'required|alpha_num|between:4,32|confirmed',
		'password_confirmation' => 'required|alpha_num|between:4,32',
	 	'bio' => 'max:500'
	);
	
		
	public static function validate($data) {
	 	$rules = array_add(static::$rules, 'email', 'required|email|unique:users,email,'.$data['id']);
		return Validator::make($data, $rules);
	}
	
}