<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TasksController extends Controller
{
    public function index()
    {
        //
        $tasks = Task::where('user_id', auth()->user()->id)->orderBy('complete', 'asc')->get();
        return response()->json($tasks);
    }
    public function store(Request $request)
    {
        //
        $request->validate([
            'task' => 'required|string|max:255',
        ]);
        $task = Task::create([
            'task' => $request->input('task'),
            'user_id' => auth()->user()->id,
        ]);
        return response()->json(['message' => 'Task added  successfully']);
    }

    public function update(Request $request, Task $task)
    {
        if (! Gate::allows('update-post', $task)) {
            abort(403);
        }
        if ($request->input('task')) {
            $request->validate([
                'task' => 'required|string|max:255',
            ]);
            $task->task = $request->input('task');
            $task->save();
        } else {
            $task->complete = !$task->complete;
            $task->save();
        }
        return response()->json(['message' => 'Task update successfully']);
       
    }

    public function destroy(Task $task)
    {
        //
        if (! Gate::allows('update-post', $task)) {
            abort(403);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
