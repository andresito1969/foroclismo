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

    // TODO : Auth::check()
    public function show(Request $request): View {

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
                ->orderBy('comments.id')
                ->get();

        return view('topic.single_topic', [
            'topic' => Topic::findOrFail($id),
            'comments' => $commentList,
            'isLogged' => Auth::check()
            //'comments' => Topic::find($id)->comments
        ]);
    }

    public function createTopicView(): View{
        $user = Auth::user();
        return view('topic.create_topic');
    }

    public function createTopic(Request $request) {
        $topic = new Topic([
            'title' => $request->title,
            'topic_text' => $request->topic_text,
            'user_id' => Auth::user()->id
        ]);

        $topic->save();

        return redirect('/');
    }
}
