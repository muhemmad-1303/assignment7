@extends('layout.app')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="maintodopage">
        <form action="/logout" method="post" >
            @csrf
            <button type="submit" id="logout">Logout</button>
        </form>
        <div class="todocard">
            <div class="todocardhead">
            <form id="add-task-form">
                @csrf
                <input type="text" name="task" id="task" >
                <button type="submit" class="addTask">Add Task</button>
            </form>
            </div>
            <div class="todocardbody" id="task-list">
            
        </div>
        </div>
    </div>
    <div class="modal modalHidden">
        <div class="modalContent">
            <div class="text">Are you sure you want to delete</div>
            <div class="buttons">
               
            </div>
        </div>
</div> 
@endsection
@section('script')
    <script src="{{ asset('js/script.js') }}"></script>
@endsection