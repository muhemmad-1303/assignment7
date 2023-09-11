@extends('layout.app')
@section('content')
<div class="mainregister">
        <div class="registercard">
            <h1>Create new account</h1>
            <form action="/register" method="post">
                @csrf
            <div class="registerbody">
                <div class="inputbox">
                    <label>User name:</label>
                    <input type="text" name="username" id="username" value="{{ old('username')}}">
                    @error('username')
                    <span>{{$message}}</span>
                   @enderror
                </div>
                <div class="inputbox">
                    <label>Email:</label>
                    <input type="text" name="email" id="email" value="{{ old('email')}}">
                    @error('email')
                    <span>{{$message}}</span>
                @enderror
                </div>
                <div class="inputbox">
                    <label>password</label>
                    <input type="password" name="password" id="password" value="{{ old('password')}}">
                    @error('password')
                    <span>{{$message}}</span>
                    @enderror
                </div>
                <div class="radiobtn">
                    <div class="radiobox">
                    <label>Male</label>
                    <input type="radio" name="gender" value="male"  {{ old("gender") === 'male' ? 'checked' : '' }}>
                   </div>
                   <div class="radiobox">
                    <label>Female</label>
                    <input type="radio" name="gender" value="female" {{ old("gender") === 'female' ? 'checked' : '' }}>
                  </div>
                  <div class="radiobox">
                    <label>Other</label>
                    <input type="radio" name="gender" value="other" {{ old("gender") === 'other' ? 'checked' : '' }}>
                  </div> 
                </div>
                @error('gender')
                    <span>{{$message}}</span>
                @enderror
               <input type="submit" value="Sign Up" id="sub">
               
            </div>
            </form>
            <div id="signin"><a href="/">Already have an account?SignIn</a></div>
        </div>
    </div>

@endsection