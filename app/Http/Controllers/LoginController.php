<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function index(){
        return view('login');
    }
    public function loginRequest(Request $request){
        $data=$request->validate(
            [
                'username'=>'required','alpha_num',
                'password'=>'required'
            ]
            );
        if(auth()->attempt($data)){
            return redirect('/todo')->with('success',"welcome");
        }
        throw ValidationException::withMessages([
            "username"=> "user name dosent exist"
        ]);
    }

    public function logoutRequest(){
        auth()->logout();
        return redirect('/');
    }
}
