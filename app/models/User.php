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
	 * The rules used for validation
	 *
	 * Whenever possible the forms should be validated on the client side
	 * and this should be used as a failsafe against spoofing
	 * @var array
	 */
	public static $rules = [
			// use special rules 
            'password'=>'required|confirmed|min:6'
		];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Fields that are okay for mass assignment
	 *
	 * @var array
	 */
	protected $fillable = array('email', 'username', 'password');

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
	 * Get the profiles for the user for social login
	 *
	 * @return model
	 */
	public function profiles()
	{
		return $this->hasMany('Profile');
	}

}