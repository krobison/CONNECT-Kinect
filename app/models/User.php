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
	
	public function posts() {
		return $this->hasMany('Post');
	}
	
	public function comments() {
		return $this->hasMany('Comment');
	}
	
	public function recieved_messages() {
		return $this->belongsToMany('Message');
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
	
	/**
	 *	Other functions.
	 */

	public function getProfilePictureURL() {
		if ($this != null && !empty($this->picture)) {
			if ( File::exists('assets/img/profile_images/' . $this->picture )) {
				return 'assets/img/profile_images/' . $this->picture;
			} else {
				return 'assets/img/dummy.png';
			}
		} else {
			return 'assets/img/dummy.png';
		}
	}
	
	public static function getSignupsOverTime() {
		$date = new DateTime('tomorrow -1 month');
		// lists() does not accept raw queries,
		// so you have to specify the SELECT clause
		$days = User::select(array(
				DB::raw('DATE(`created_at`) as `date`'),
				DB::raw('COUNT(*) as `count`')
			))
			->where('created_at', '>', $date)
			->group_by('date')
			->order_by('date', 'DESC')
			->lists('count', 'date');

		return $date;
	}
}