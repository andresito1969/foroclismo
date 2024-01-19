<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;

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

// LOGIN & REGISTER VIEW
Route::get('/login', [UserController::class, 'loginView'])->name('login_view');
Route::get('/register', [UserController::class, 'registerView'])->name('register_view');
// POST (CREATE LOGIN SESSION, CREATE OR REGISTER USER)
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
// DELETE (LOGOUT USER, DELETE USER)
// Logout Route::delete('/logout');
// Delete Route::delete('/delete_user');



// TOPIC VIEWS
Route::get('/', [TopicController::class, 'show']);
Route::get('/topic/{id}', [TopicController::class, 'showOne'])->name('single_topic');
// crear topic
// editar topic
// eliminar topic



// USER VIEWS
Route::get('/user/{id}', [UserController::class, 'show'])->name('profile');
// editar 
// eliminar


// crear comentario
// editar comentario
// eliminar comentario