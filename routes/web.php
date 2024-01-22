<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CommentController;

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
Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::get('/register', [UserController::class, 'registerView'])->name('register_view');
// POST (CREATE LOGIN SESSION, CREATE OR REGISTER USER)
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
// DELETE (LOGOUT USER, DELETE USER)
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// Delete Route::delete('/delete_user');



// TOPIC VIEWS
Route::get('/', [TopicController::class, 'show'])->name('home');
Route::get('/topic/{id}', [TopicController::class, 'showOne'])->name('single_topic');
Route::get('/create_topic', [TopicController::class, 'createTopicView'])->name('create_topic')->middleware('auth');
Route::post('/create_topic', [TopicController::class, 'createTopic'])->middleware('auth');

// editar topic
// eliminar topic



// USER VIEWS
Route::get('/user/{id}', [UserController::class, 'show'])->name('profile');
// editar 
// eliminar

// COMMENT VIEWS
Route::get('/topic/{id}/create_comment', [CommentController::class, 'createCommentView'])->name('create_comment_view')->middleware('auth');
Route::post('/topic/{id}/create_comment', [CommentController::class, 'createComment'])->name('create_comment')->middleware('auth');
// editar comentario
// eliminar comentario