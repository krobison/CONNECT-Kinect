<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

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
	 *	Relationships.
	 */
	
	public function courses() {
		return $this->belongsToMany('Course');
	}
	
	public function hashtags() {
		return $this->belongsToMany('Hashtag');
	}
	
	public function messages() {
		return $this->belongsToMany('Message');
	}
	
	public function posts() {
		return $this->hasMany('Post');
	}
	
	public function comments() {
		return $this->hasMany('Comment');
	}

	//public function sent_messages()	{
	//	return $this->hasMany('Message', 'from');
	//}
	
	/**
	 *	Validation rules.
	 */
	 
	public static $rules = array(
		'first' => 'required|alpha|max:20',
		'last' => 'required|alpha|max:20',
		'email' => 'required|email|unique:users',
		'password' => 'required|alpha_num|between:4,32|confirmed',
		'password_confirmation' => 'required|alpha_num|between:4,32',
		'profilepic' => 'image|max:2000'
	);
	
	public static $editrules = array(
		'first' => 'required|alpha|max:20',
		'last' => 'required|alpha|max:20',
		'new' => 'required|alpha_num|between:4,32|confirmed',
		'new_confirmation' => 'required|alpha_num|between:4,32',
	);
	
	public static $editrulesnopass = array(
		'first' => 'required|alpha|max:20',
		'last' => 'required|alpha|max:20',
	);

	public static function validate($data) {
	 	$rules = array_add(static::$rules, 'email', 'required|email|unique:users,email,'.$data['id']);
		return Validator::make($data, $rules);
	}
	
}