<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
     public function showTask(){
         return view('todo',['tasks'=>[]]);  
     }
    public function storeTask(Request $request)
    {

    $request->validate([
        'task' => 'required|string|max:255',
    ]);

    $task = new Task();
    $task->task = $request->input('task');
    $task->user_id = auth()->user()->id;
    $task->save();
    return response()->json($task);
   }
   public function fetchTasks()
   {
    $tasks = Task::where('user_id', auth()->user()->id)->orderBy('complete','asc')->get();
    return response()->json($tasks);
    }

    public function deleteTask($id){
   
    $task = Task::find($id);
    $task->delete();
    return response()->json(['message' => 'Task deleted successfully']);
   }
   public function completeTask($id)
   {
    $task = Task::find($id);
    
    $task->complete=true;
    $task->save();
    return response()->json(['message' => 'Task completed successfully']);
   }
   public function undoTask($id)
   {
    $task = Task::find($id);
    $task->complete=false;
    $task->save();
    return response()->json(['message' => 'Task undo successfully']);
   }
   public function updateTask(Request $request, $id)
   {
    
    $task = Task::find($id);
    $request->validate([
        'task' => 'required|string|max:255',
    ]);
    $task->task = $request->input('task');
    $task->save();
    return response()->json(['message' => 'Task update successfully']);
  }
   

}
