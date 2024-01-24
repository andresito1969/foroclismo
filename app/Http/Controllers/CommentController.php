<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // En algunas vistas como la vista de creación de topic, no necesitamos revisar si el usuario está logeado, debido a que en el
    // router (routes/web.php) el middleware ya nos verifica si el usuario está autenticado, en caso contrario lo redirige al login automáticamente.
    
    // Enlaza la vista para crear los comentarios
    public function createCommentView($id): View{
        return view('comment.create_comment', [
            'topic_id' => $id
        ]);
    }
    
    // Esta función nos permite crear comentarios
    public function createComment(Request $request, $topicId) {
        $isValidText = Comment::textLengthCheck($request->text);
        $isAuthenticated = Auth::check();
        $isValidTopic = $this->isValidTopic($topicId);

        // Si no son correctas estas comprobaciones ejecuta el else.
        if($isValidText && $isAuthenticated && $isValidTopic) {
            $comment = new Comment([
                'text' => $request->text,
                'user_id' => Auth::user()->id,
                'topic_id' => $topicId
            ]);
            $comment->save();
            return redirect('/topic/' . $topicId);
        } else {
            $genericError = "¡Vaya! Algo ha fallado...";
            $textError = "Tu comentario es demasiado largo o demasiado corto, debes poner entre 0 y 65535 carácteres...";
            return back()->withErrors([
                // Si el texto es válido, poner un error genérico, de lo contrario informa que el comentario es o muy corto o muy largo.
                'text_error' => $isValidText ? $genericError : $textError,
            ]);
        }
    }

    public function editCommentView(Request $request, $topicId, $commentId) {
        $comment = Comment::findOrFail($commentId);
        $isValidUserId = $comment->user_id == Auth::user()->id;
        if(Auth::user()->is_admin || $isValidUserId) {
            return view('comment.edit_comment', [
                'topic_id' => $topicId,
                'comment' => $comment
            ]);
        } else {
            return back()->withErrors([
                'malicious_edit_error' => '¡Eps! Estás intentando editar un comentario que no es tuyo? :(',
            ]);
        }        
    }

    public function editComment(Request $request, $topicId, $commentId) {
        $isValidText = Comment::textLengthCheck($request->text);
        $isValidTopic = $this->isValidTopic($topicId);
        $comment = Comment::findOrFail($commentId);
        $isValidUserId = $this->isValidUserId($comment->user_id);
        if(Auth::user()->is_admin || ($isValidUserId && $isValidTopic && $isValidText)) {
            $comment->update(['text' => $request->text]);
            return redirect('/topic/' . $topicId);
        }
        return back()->withErrors([
            'text_error' => $isValidText ? 'Algo ha fallado, vuelve a intentarlo' : 'Recuerda que debes poner un comentario entre 0 y 65535 carácteres...',
        ]);
    }
    
    public function deleteComment(Request $request, $topicId, $commentId) {
        $comment = Comment::findOrFail($commentId);
        $isValidUserId = $this->isValidUserId($comment->user_id);
        $isValidTopic = $this->isValidTopic($topicId);

        if(Auth::user()->is_admin || ($isValidUserId && $isValidTopic)) {
            $comment->delete();
            return redirect('/topic/' . $topicId);
        }

        return redirect('/topic/' . $topicId)->withErrors([
            'malicious_delete' => 'No intentes borrar un comentario que no es tuyo!'
        ]);
    }


    /**
     * Funciones comunes usadas para añadir capas de seguridad.
     */

    private function isValidUserId($userId) {
        return $userId == Auth::user()->id;
    }

    private function isValidTopic($id) {
        return count(Topic::where("id", $id)->get());
    }
}
