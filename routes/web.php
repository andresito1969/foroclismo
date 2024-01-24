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


// Agrupaciones por middleware y prefijo, así no tenemos que ir llamando al método middleware (que nos verifica si está autenticado el usuario)
Route::group(['middleware' => 'auth', 'prefix' => 'topic'], function() {
    
    // GET Y POST (CREACIÓN) DE UN TOPIC
    Route::get('/create/topic', [TopicController::class, 'createTopicView'])->name('create_topic_view');
    Route::post('/create', [TopicController::class, 'createTopic'])->name('create_topic');
    
    // GET Y UPDATE DE UN TOPIC & BORRADO DEL TOPIC
    Route::get('/{topic_id}/edit_topic', [TopicController::class, 'editTopicView'])->name('edit_topic_view');
    Route::patch('/{topic_id}/edit_topic', [TopicController::class, 'editTopic'])->name('edit_topic');
    Route::delete('/{topic_id}/delete', [TopicController::class, 'deleteTopic'])->name('delete_topic');  
    Route::get('/{topic_id}/create_comment', [CommentController::class, 'createCommentView'])->name('create_comment_view');
    Route::post('/{topic_id}/create_comment', [CommentController::class, 'createComment'])->name('create_comment');

    // GET & UPDATE & BORRADO DE COMENTARIO
    Route::get('/{topic_id}/edit_comment/{comment_id}', [CommentController::class, 'editCommentView'])->name('edit_comment_view');
    Route::patch('/{topic_id}/edit_comment/{comment_id}', [CommentController::class, 'editComment'])->name('edit_comment');
    Route::delete('/{topic_id}/comment/{comment_id}', [CommentController::class, 'deleteComment'])->name('delete_comment');  
});



// PERFIL DEL USUARIO
Route::get('/user/{user_id}', [UserController::class, 'show'])->name('profile');
// editar 
// eliminar