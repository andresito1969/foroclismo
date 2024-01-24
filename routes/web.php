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

/*
 * LOGIN & REGISTER & LOGOUT 
 */
// LOGIN & REGISTER VISTAS
Route::get('/login', [UserController::class, 'loginView'])->name('login');
Route::get('/register', [UserController::class, 'registerView'])->name('register_view');

// LOGIN & REGISTER MÉTODOS
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

// LOGOUT USER MÉTODO, NO SE NECESITA VISTA PARA EL LOGOUT 
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



/*
 * TOPICS & ÚNICO TOPIC & CREACIÓN/ACTUALIZACIÓN/BORRADO
 */
// GET DE TODOS LOS TOPICS & GET DE UN ÚNICO TÓPIC
Route::get('/', [TopicController::class, 'show'])->name('home');
Route::get('/topic/{topic_id}', [TopicController::class, 'showOne'])->name('single_topic');

// GET Y POST (CREACIÓN) DE UN TOPIC
Route::get('/create_topic', [TopicController::class, 'createTopicView'])->name('create_topic')->middleware('auth');
Route::post('/create_topic', [TopicController::class, 'createTopic']);

// GET Y UPDATE DE UN TOPIC & BORRADO DEL TOPIC
Route::get('/topic/{topic_id}/edit_topic', [TopicController::class, 'editTopicView'])->name('edit_topic_view')->middleware('auth');
Route::patch('/topic/{topic_id}/edit_topic', [TopicController::class, 'editTopic'])->name('edit_topic')->middleware('auth');
Route::delete('/topic/{topic_id}/delete', [TopicController::class, 'deleteTopic'])->name('delete_topic')->middleware('auth');



// PERFIL DEL USUARIO
Route::get('/user/{user_id}', [UserController::class, 'show'])->name('profile');
// editar 
// eliminar



/* 
 * VISTA DE CREACIÓN, VISTA DE EDICIÓN Y BORRADO DE COMENTARIOS
 * LOS COMENTARIOS NO TENDRÁN UNA VISTA DE MOSTRADO COMO TAL PORQUE PERTENECEN AL TOPIC!
 */
 // GET Y POST DE COMENTARIO
Route::get('/topic/{topic_id}/create_comment', [CommentController::class, 'createCommentView'])->name('create_comment_view')->middleware('auth');
Route::post('/topic/{topic_id}/create_comment', [CommentController::class, 'createComment'])->name('create_comment')->middleware('auth');

// GET & UPDATE & BORRADO DE COMENTARIO
Route::get('/topic/{topic_id}/edit_comment/{comment_id}', [CommentController::class, 'editCommentView'])->name('edit_comment_view')->middleware('auth');
Route::patch('/topic/{topic_id}/edit_comment/{comment_id}', [CommentController::class, 'editComment'])->name('edit_comment')->middleware('auth');
Route::delete('/topic/{topic_id}/comment/{comment_id}', [CommentController::class, 'deleteComment'])->name('delete_comment')->middleware('auth');