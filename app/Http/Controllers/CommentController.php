<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Traits\ErrorTextTrait;


class CommentController extends Controller
{
    /* 
     * Nos permite acceder al trait (funciones genericas de toda la app), este trait en concreto
     * nos va a devolver los textos de errores, así los tendremos centralizados y no hardcodeados en la app...
     * Para que de un vistazo cambiemos los textos de errores genéricos de la app
     */
    use ErrorTextTrait; 

    /*
     * Info adicional: En algunas vistas como la vista de creación de topic, no necesitamos revisar si el usuario está logeado, debido a que en el
     * router (routes/web.php) el middleware ya nos verifica si el usuario está autenticado, en caso contrario lo redirige al login automáticamente.
     */
    
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
            $genericError = $this->getGenericError();
            $textError = $this->getCommentTextLengthError();
            return back()->withErrors([
                // Si el texto es válido, pone un error genérico, de lo contrario informa que el comentario es o muy corto o muy largo.
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
                'malicious_edit_error' => $this->getCommentMaliciousEdit(),
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
        $genericError = $this->getGenericError();
        $textError = $this->getCommentTextLengthError();

        return back()->withErrors([
            'text_error' => $isValidText ? $genericError : $textError
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
            'malicious_delete' => $this->getCommentMaliciousDelete()
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
