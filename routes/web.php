<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Middleware\TaskOwnerCheckMiddleware;
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
Route::get('/register',[LoginController::class,'createUserIndex'])->middleware('guest');
Route::post('/register',[LoginController::class,'createUserRequest'])->middleware('guest');
Route::get('/',[LoginController::class,'index'])->name("task.login")->middleware('guest');
Route::post('/login',[LoginController::class,'loginRequest'])->name("task.loginvalidation")->middleware('guest');
Route::post('/logout',[LoginController::class,'logoutRequest'])->middleware('auth');
Route::get('/todo',[TodoController::class,'index'])->middleware('auth');
Route::resource('/api/tasks',TasksController::class)->middleware('auth'::class)->except(['create', 'edit']);
Route::get('/{any}', function () {
    abort(404);
})->where('any', '.*');





