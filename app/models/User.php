<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	protected $fillable = array('first_name', 'last_name', 'email', 'password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	/**
	 *	Begin my shenanigans.
	 */
	
	/**
	 *	Validation rules.
	 */
	 
	public static $rules = array(
		'first' => 'required',
		'last' => 'required',
		'email' => 'required',
		'password' => 'required|confirmed',
		'password_confirmation' => 'required',
	 	'bio' => 'max:500'
	);
	
		
	public static function validate($data) {
	 	$rules = array_add(static::$rules, 'email', 'required|email|unique:users,email,'.$data['id']);
		return Validator::make($data, $rules);
	}
	
	/**
	 *	Relationships.
	 */
	
	public function roles() {
		return $this->belongsToMany('Role');
	}
	
	public function interests() {
		return $this->belongsToMany('Interest');
	}
	
	public function photo() {
		return $this->hasOne('Photo');
	}
	  

}