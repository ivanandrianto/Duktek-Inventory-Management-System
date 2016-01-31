<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use Validator;
use Input;
use Auth;
use Redirect;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Log;
use View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $redirectPath = '/dashboard';
    protected $loginPath = 'auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admin',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin()
    {
        // show the form
        /*if (Auth::check()) {
            return Redirect::to('dashboard');
        }*/
        return View::make('auth.login');
    }

    public function postLogin()
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);

        
        // show the form
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('auth/login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            
            // create our user data for the authentication
            $admindata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );
            //return Redirect::to(Hash::make((Input::get('password'))));
            // attempt to do the login
            $output->writeln('postlogin');
            if (Auth::attempt($admindata)) {

                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                echo 'SUCCESS!';
                //return Redirect::to('SUCCESS');

            } else {

                $admin = Auth::admin();
                // validation not successful, send back to form 
                return Redirect::to($admin);

            }


        }
    }

    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('auth/login'); // redirect the user to the login screen
    }


}