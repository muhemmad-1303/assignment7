<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('login');
    }

    public function loginRequest(Request $request)
    {
        $data = $request->validate(
            [
                'username' => 'required', 'alpha_num',
                'password' => 'required',
            ]
        );
        if (auth()->attempt($data)) {
            $cookie = cookie('userId',auth()->user()->id,1440)->withHttpOnly(false);
            return redirect('/todo')->with('success', 'welcome')->withCookie($cookie);;
        }
        throw ValidationException::withMessages([
            'username' => 'user name dosent exist',
        ]);
    }

    public function logoutRequest()
    {
        auth()->logout();
        return redirect('/');
    }
    public function Request()
    {
        return redirect('/todo');
    }
    public function createUserIndex(){
        return view('create');
    }
    public function CreateUserRequest(Request $request){
        $data = $request->validate([
            'username' => ['required', 'alpha_num', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'gender' => ['required'],
        ]);
        $data['password']=bcrypt($data["password"]);
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'gender' => $data['gender'],
        ]);   
        return redirect(route("task.login")); 
    }
}
