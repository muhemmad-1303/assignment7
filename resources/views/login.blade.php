@extends('layout.app')
@section('content')
<div class="mainlogin">
        <div class="logincard">
            <form action="/login" method="post">
                @csrf
                <div class="inputbox">
                <label>User Name:</label>
                <input type="text" id="user" name="username" value="{{old('username')}}">
                @error('username')
                    <span>{{$message}}</span>
                @enderror
                </div>
                <div class="inputbox">
                <label>Password:</label>
                <input type="password" id="passwordlogin" name="password" value="{{old('password')}}">
                @error('password')
                    <span>{{$message}}</span>
                @enderror
                </div>
                <input type="submit" value="Login">
                <hr>
            </form>
            <div id="createAccount"><a href="/register">Create New Account</a></div>
        </div>
    </div>   
@endsection