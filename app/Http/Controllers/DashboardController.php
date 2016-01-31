<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;

class DashboardController extends Controller
{

    public function __construct ()
    {
        if (Auth::check()) {
        } else {
            return Redirect::to('/')->send();
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            // The user is logged in...
            // get all the users
            $users = User::all();
            echo "Welcome " . Auth::user()->email;
            echo "<a href='/auth/logout'>Logout</a>";
            // load the view and pass the nerds
           
            return view('users.index', compact('users'));
        } else {
            echo "You're not logged in";
        }
        
    }
}