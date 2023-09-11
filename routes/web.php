<?php

use App\Http\Controllers\CreateController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/register',[CreateController::class,'index'])->middleware('guest');
Route::post('/register',[CreateController::class,'createRequest'])->middleware('guest');
Route::get('/',[LoginController::class,'index'])->name("task.login")->middleware('guest');
Route::post('/login',[LoginController::class,'loginRequest'])->name("task.loginvalidation")->middleware('guest');
Route::post('/logout',[LoginController::class,'logoutRequest'])->middleware('auth');
Route::get('/todo',[TaskController::class,'showTask'])->middleware('auth');
Route::get('/api/tasks', [TaskController::class, 'fetchTasks'])->middleware('auth');
Route::post('/api/tasks', [TaskController::class, 'storeTask'])->middleware('auth');
Route::delete('/api/tasks/{id}', [TaskController::class, 'deleteTask'])->middleware('auth');
Route::put('/api/tasks/{id}/complete', [TaskController::class, 'completeTask'])->middleware('auth');
Route::put('/api/tasks/{id}/undo', [TaskController::class, 'undoTask'])->middleware('auth');
Route::put('/api/tasks/{id}/edit', [TaskController::class, 'updateTask'])->middleware('auth');



