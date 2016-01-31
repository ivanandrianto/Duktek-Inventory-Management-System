<?php

namespace App\Http\Controllers;
require app_path().'\helper.php';
use Illuminate\Http\Request;

use Log;
use Hash;
use Auth;
use App\Admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;


class AdminController extends Controller
{

    /*public function __construct ()
    {
        if (Auth::check()) {
        } else {
            return Redirect::to('/')->send();
        }
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::all();

        return view('admin.index', compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'name'        => 'required',
            'email'       => 'required|email',
            'password'    => 'required',
            'password2'    => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('admin/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $admin = new Admin;
            $admin->name       = Input::get('name');
            $admin->email      = Input::get('email');

            if(Input::get('password')!=Input::get('password2')){
                Session::flash('_errors', 'Password not match');
                return Redirect::to('admin/create');
            } else {
                $admin->password = Hash::make((Input::get('password')));
                $admin->save();
                Session::flash('message', 'Successfully registered!');
                return Redirect::to('admin');
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
         $admin = Admin::find($id);

        // show the view and pass the nerd to it
        return view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // get the nerd
        $admin = Admin::find($id);

        // show the edit form and pass the nerd
       return view('admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = array(
            'name'        => 'required',
            'email'       => 'required|email',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('admin/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $admin = Admin::find($id);
            $admin->name       = Input::get('name');
            $admin->email      = Input::get('email');
            $admin->save();

            // redirect
            Session::flash('message', 'Successfully updated!');
            return Redirect::to('admin');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function foundAdminWithEmail(){
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);

        // Getting all post data
        
        $email = Input::get('email');
        
        $column = 'email'; // This is the name of the column you wish to search
        $n = Admin::where($column , '=', $email)->count();
        $output->writeln($n);
        $result = null;
        if($n>0){
            $result = 'Email sudah terdaftar';
        } else {
            $output->writeln('else');
        }
        echo json_encode($result);
        
    }

}
