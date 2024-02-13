<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Traits\ErrorTextTrait;
use App\Traits\UtilsTrait;

use App\Repositories\CommentRepositoryInterface;
use App\Repositories\TopicRepositoryInterface;

class CommentController extends Controller
{
    /* 
     * Nos permite acceder al trait (funciones genericas de toda la app), este trait en concreto
     * nos va a devolver los textos de errores, así los tendremos centralizados y no hardcodeados en la app...
     * Para que de un vistazo cambiemos los textos de errores genéricos de la app
     */
    use ErrorTextTrait, UtilsTrait; 

    private $topicRepository, $commentRepository;

    public function __construct(TopicRepositoryInterface $topicRepository, CommentRepositoryInterface $commentRepository) {
        $this->topicRepository = $topicRepository;
        $this->commentRepository = $commentRepository;
    }
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
        $isValidText = $this->commentRepository->getTextLengthCheck($request->text);
        $isAuthenticated = Auth::check();
        $isValidTopic = $this->isValidTopic($topicId);

        // Si no son correctas estas comprobaciones ejecuta el else.
        if($isValidText && $isAuthenticated && $isValidTopic) {
            $this->commentRepository->createComment([
                'text' => $request->text,
                'user_id' => Auth::user()->id,
                'topic_id' => $topicId
            ]);
            return redirect('/topic/' . $topicId);
        } 
        $genericError = $this->getGenericError();
        $textError = $this->getCommentTextLengthError();
        return back()->withErrors([
            // Si el texto es válido, pone un error genérico, de lo contrario informa que el comentario es o muy corto o muy largo.
            'text_error' => $isValidText ? $genericError : $textError,
        ])->withInput();
    }

    public function editCommentView(Request $request, $topicId, $commentId) {
        $comment = $this->commentRepository->getSingleMessage($commentId);
        $isValidUserId = $this->checkValidAuthUser($comment->user_id);
        $isSuperUser = $this->isSuperUser();

        if($isSuperUser || $isValidUserId) {
            return view('comment.edit_comment', [
                'topic_id' => $topicId,
                'comment' => $comment
            ]);
        } else {
            return back()->withErrors([
                'malicious_edit_error' => $this->getCommentMaliciousEditError(),
            ]);
        }        
    }

    public function editComment(Request $request, $topicId, $commentId) {
        $isValidText = $this->commentRepository->getTextLengthCheck($request->text);
        $isValidTopic = $this->isValidTopic($topicId);
        $comment = $this->commentRepository->getSingleMessage($commentId);
        $isValidUserId = $this->checkValidAuthUser($comment->user_id);
        $isSuperUser = $this->isSuperUser();
        
        if(($isSuperUser || $isValidUserId) && $isValidTopic && $isValidText) {
            $this->commentRepository->update($comment, ['text' => $request->text]);
            return redirect('/topic/' . $topicId);
        }
        $genericError = $this->getGenericError();
        $textError = $this->getCommentTextLengthError();

        return back()->withErrors([
            'text_error' => $isValidText ? $genericError : $textError
        ]);
    }
    
    public function deleteComment(Request $request, $topicId, $commentId) {
        $comment = $this->commentRepository->getSingleMessage($commentId);
        $isValidUserId = $this->checkValidAuthUser($comment->user_id);
        $isValidTopic = $this->isValidTopic($topicId);

        if((Auth::user()->is_admin || $isValidUserId) && $isValidTopic) {
            $this->commentRepository->delete($comment);
            return redirect('/topic/' . $topicId);
        }

        return redirect('/topic/' . $topicId)->withErrors([
            'malicious_delete' => $this->getCommentMaliciousDeleteError()
        ]);
    }

    private function isValidTopic($id) {
        return $this->topicRepository->getSingleTopic($id);
    }
}
