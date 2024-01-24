<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\Topic;
use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{

    // En algunas vistas como la vista de creación de topic, no necesitamos revisar si el usuario está logeado, debido a que en el
    // router (routes/web.php) el middleware ya nos verifica si el usuario está autenticado, en caso contrario lo redirige al login automáticamente.
    public function show(): View {

        $topicList = DB::table('topics')
                    ->leftjoin('users', 'users.id', 'topics.user_id')
                    ->select('topics.*', 'users.name', 'users.last_name')
                    ->orderBy('topics.id', 'DESC')
                    ->get();
                    
        return view('topic.topics', [
            'topics' => $topicList,
            'isLogged' => Auth::check()
        ]);
    }

    public function showOne($id): View{
        $commentList = DB::table('comments')
                ->join('users', 'users.id', 'comments.user_id')
                ->where('comments.topic_id', '=', $id)
                ->select('comments.*', 'users.name', 'users.last_name')
                ->orderBy('comments.id')
                ->get();

        $isLogged = Auth::check();
        return view('topic.single_topic', [
            'topic' => Topic::findOrFail($id),
            'comments' => $commentList,
            'isLogged' => $isLogged,
            'user_id' => $isLogged ? Auth::user()->id : 0,
            'isAdmin' => $isLogged ? Auth::user()->is_admin : 0
        ]);
    }

    public function createTopicView(): View{
        return view('topic.create_topic');
    }

    public function createTopic(Request $request) {
        $isValidTitle = Topic::titleLengthCheck($request->title);
        $isValidText = Topic::textLengthCheck($request->topic_text);

        if(Auth::check() && $isValidTitle && $isValidText) {
            $topic = new Topic([
                'title' => $request->title,
                'topic_text' => $request->topic_text,
                'user_id' => Auth::id()
            ]);
    
            $topic->save();
    
            return redirect('/');
        }
        
        return back()->withErrors([
            'text_error' => $isValidText ? '' : 'El texto tiene que ser menor o igual a 65535 carácteres',
            'title_error' => $isValidTitle ? '' : 'El titulo tiene que estar entre 0 y 80 carácteres',
        ]);
    }

    public function deleteTopic($topicId) {
        $topic = Topic::findOrFail($topicId);
        $isValidUser = $this->isValidUserId($topic->user_id);
        if(Auth::user()->is_admin || ($isValidUser && $topic)) {
            $topic->comments()->delete(); // esta línea nos va a permitir borrar los comentarios asociados al topic, de lo contrario vamos a tener una incosistencia!
            $topic->delete();
        }
        
        return redirect('/');
    }

    public function editTopicView(Request $request, $topicId) {
        $topic = Topic::findOrFail($topicId);
        $isValidUserId = $this->isValidUserId($topic->user_id);
        if(Auth::user()->is_admin || $isValidUserId) {
            return view('topic.edit_topic', [
                'topic' => $topic
            ]);
        } else {
            return back()->withErrors([
                'malicious_edit_error' => '¡Eps! Estás intentando editar un topic que no es tuyo? :(',
            ]);
        }        
    }

    public function editTopic(Request $request, $topicId){
        $isValidText = Topic::textLengthCheck($request->text);
        $topic = Topic::findOrFail($topicId);
        $isValidTitle = Topic::titleLengthCheck($request->title);
        $isValidUserId = $this->isValidUserId($topic->user_id);
        if(Auth::user()->is_admin || ($isValidUserId && $isValidText)) {
            $topic->update([
                'topic_text' => $request->text,
                'title' => $request->title
            ]);
            return redirect('/topic/' . $topicId);
        }
        return back()->withErrors([
            'text_error' => $isValidText ? 'Algo ha fallado, vuelve a intentarlo' : 'Recuerda que debes poner un comentario entre 0 y 65535 carácteres...',
        ]);
    }

    /**
     * Funciones comunes usadas para añadir capas de seguridad.
     */

    private function isValidUserId($userId) {
        return $userId == Auth::user()->id;
    }
}
