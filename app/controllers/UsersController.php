<?php

class UsersController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	

		// check if the user is logged in
		// &
		// if they are an admin
		if (Auth::check() && Auth::user()->admin){
		
			// return the users index view
			return View::make('users.index')
				->with('title', 'Users index view');

		// otherwise...
		} else {

			// redirect home
			return Redirect::home();
		
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// return the create view
		return View::make('users.create')
			->with('title', 'Users create view');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        // grab the passed input
        $inputs = Input::all();
		// validate the user attempting to be created
		// with the $rules from the User model
        $validation = Validator::make($inputs, User::$rules);

        // if validation passess...
        if ($validation->passes()) {

        	// create the new user
            User::create(array(
                'email'=>Input::get('email'),
                'password'=>Hash::make(Input::get('password'))
            ));

            // log the user in 
            $user  = User::where('email', '=', Input::get('email'))->first();
            Auth::loginUsingId($user->id);
            
            // create a blank profile for them too
            // at some point this should be given first & last name?
            // $profile = new Profile([
            //     'first_name'=>'Jordan',
            //     'last_name'=>'Skole'
            //     ]);

            // save the profile to the user
            // $user->profile()->save($profile);           

            // and redirect them to the dashboard screen
            return Redirect::home()
                ->with('message', 'Welcome to Heather Read Photography & Design!')
                ->with('message-class', 'alert-success');

        // if validation doesn't pass
        } else {

        	// if they don't pass validation redirect them back to register page with errors
            return Redirect::route('users.create')

                // with validation errors 
                ->withErrors($validation)

                // and their input 
                ->withInput();
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        $user = User::find($id);

		// if the logged in user == the requested user
        // or 
        // if the logged in user is admin
        if(Auth::user() == $user || Auth::user()->admin == true) {
            // we want the edit user view
            return Redirect::route('users.edit', [$user->id]);
        // if the user is only logged in
        } elseif(Auth::check()) {

            // otherwise we just want the public show view
            return View::make('users.show')
                ->with('user', $user)
                ->with('title', 'User show view (logged in)');
        } else {
            // if the user isn't logged in
            // just show the view
            return View::make('users.show')
                ->with('user', $user)
                ->with('title', 'User show view (logged out)');
        }

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        
		$user = User::find($id);

        // if the logged in user == the requested user
        // or 
        // if the logged in user is admin
        if(Auth::user() == $user || Auth::user()->admin == true) {
            // we want the edit user view
            return View::make('users.edit')
                ->with('user', $user)
                ->with('title', 'User edit view');
        } else {

            // otherwise we just want the public show view
            return Redirect::route('users.index');
        }

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Logout the current user
	 *
	 * @return Response
	 */

	public function logout()
	{
		// Logout the current user
        Auth::logout();

        // and redirect them back home
        return Redirect::home()
            ->with('message', 'You have successfully logged out.');
    }

    /**
     * get the Login screen
     *
     * @return Response
     */

    public function getLogin()
    {
        // return the login view
        return View::make('users.login')
            ->with('title', 'Users login view');

    }

    /**
     * Login the current user
     *
     * @return Response
     */

    public function login()
    {
        // login the user
        // create our user variable from the form fields
        $user = array(
            'email'=>Input::get('email'),
            'password'=>Input::get('password')
        );

        // if the user exists in our database
        if(Auth::attempt($user, true)) {
            // log the user in (happens automatically)
            // (the user is already logged in via l4)
            return Redirect::home();
        } else {
            // if she doesn't return to login with error & input 
            return Redirect::route('getLogin')
                // and their input 
                ->withInput()
                ->with('message', 'email/password error');   
        }

    }

    /**
     * Login the current user with facebook
     *
     * @return Response
     */

    public function facebookLogin()
    {
        $facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('/login/fb/callback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));

    }

    /**
     * Login the current user with facebook
     *
     * @return Response
     */

    public function facebookCallback()
    {
        
        $code = Input::get('code');
        
        if (strlen($code) == 0) {
            return Redirect::to('/')
                ->with('message', 'There was an error communicating with Facebook');            
        }

        
        $facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();
         
        if ($uid == 0) {
            return Redirect::to('/')
                ->with('message', 'There was an error');
        }

        $me = $facebook->api('/me');

        $profile = Profile::whereUid($uid)->first();

        // if the fb user doesn't have a profile
        if (!$profile) {

            // but a user is already logged in
            if(Auth::check()) {
                // get the logged in user
                $user = Auth::user();

                // if the user doesn't have a photo 
                if(!$user->photo){
                    $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
                    // save the user
                    $user->save();  
                }

                // and associate the profile with that user
                $profile = new Profile();
                $profile->uid = $uid;
                $profile->username = $me['username'];
                $profile->access_token = $facebook->getAccessToken();
                $profile = $user->profiles()->save($profile);

            // if an account doesn't exist with the fb users email address
            } elseif(!User::whereEmail($me['email'])->first()) {
                
                // backwards
                $user = new User;
                $user->first_name = $me['first_name'];
                $user->last_name = $me['last_name'];
                $user->email = $me['email'];
                $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';

                // create a random password to use until the user sets their password
                $user->password = Hash::make($this->randomPassword());
                $user->force_password_change = true;

                // save the user
                $user->save();                

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->username = $me['username'];
                $profile->access_token = $facebook->getAccessToken();
                $profile = $user->profiles()->save($profile);

                // and log the user in
                Auth::login($user);

            // if an account does exist with the fb users email address
            } else {

                $user = User::whereEmail($me['email'])->first();

                // if the user doesn't have a photo 
                if(!$user->photo){
                    $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
                    
                    // save the user
                    $user->save();
                }

                $profile = new Profile();
                $profile->uid = $uid;
                $profile->username = $me['username'];
                $profile->access_token = $facebook->getAccessToken();
                $profile = $user->profiles()->save($profile);
            }            
        
        // otherwise a profile already exists
        } else {

            $profile->access_token = $facebook->getAccessToken();
            $profile->save();
            $user = $profile->user;
            if(!$user->photo){
                $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
                
                // save the user
                $user->save();
            }
            Auth::login($user);

        }
         
        return Redirect::route('home')
            ->with('message', 'Logged in with Facebook');
    }

    /**
     * Show the force password view
     *
     * @return View
     */

    public function passwordChange() {

        // fetch the logged in user
        $user = Auth::user();

        // if the user must reset the password
        if($user->force_password_change) {
            // show them the password reset view
            return View::make('users.password')
                ->with('title', 'Please reset your password')
                ->with('user', $user);
        } else {
            // if the user doesn't have a force password
            // throw them to the regular edit screen
            return Redirect::route('users.edit', $user->id);
        }
        
    }

    /**
     * Validate & store the new password
     *
     * @return Response
     */

    public function passwordStore() {

        // grab the passed input
        $inputs = Input::all();

        // validate the user attempting to be created
        // with the $rules from the User model
        $validation = Validator::make($inputs, User::$rules);

        // if validation passess...
        if ($validation->passes()) {
            
            $user = Auth::user();

            $user->password = Hash::make(Input::get('password'));
            $user->force_password_change = false;
            $user->save();

            return Redirect::home();
        } else {
            return Redirect::route('passwordChange')
                ->withErrors($validation);
        }
    }

    private function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}