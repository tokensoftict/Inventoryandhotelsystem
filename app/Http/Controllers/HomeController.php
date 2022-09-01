<?php

namespace App\Http\Controllers;

use App\Classes\Settings;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $settings;

    public function __construct(Settings $_settings)
    {

        $this->settings = $_settings;
    }


    public function index(){
        if(auth()->check())   return redirect()->route('dashboard');
        return view('login');
    }

    public function process_login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->except(['_token']);

        if (auth()->attempt($credentials)) {

            return redirect()->route('dashboard');

        }else{
            session()->flash('message', 'Invalid Username or Password, Please check and try again');
            return redirect()->back();
        }
    }


    public function logout(){
        auth()->logout();
        return redirect()->route('home');
    }

}
