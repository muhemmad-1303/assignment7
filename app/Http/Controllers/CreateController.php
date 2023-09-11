<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreateController extends Controller
{
    //

    public function index(){
        return view('create');
    }
    public function CreateRequest(Request $request){
        $data = $request->validate([
            'username' => ['required', 'alpha_num', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'gender' => ['required'],
        ]);
        $data['password']=bcrypt($data["password"]);
        $user=new User();
        $user->username=$data['username'];
        $user->email=$data['email'];
        $user->password=$data['password'];
        $user->gender=$data['gender'];
        $user->save();     
        return redirect(route("task.login")); 
    }
}
