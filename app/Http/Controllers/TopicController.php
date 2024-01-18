<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\Topic;
use Illuminate\View\View;

class TopicController extends Controller
{
    public function show(): View {
        $topicList = DB::table('topics')
                    ->leftjoin('users', 'users.id', 'topics.user_id')
                    ->select('topics.*', 'users.name', 'users.last_name')
                    ->orderBy('topics.id', 'DESC')
                    ->get();
                    
        return view('topic.topics', [
            'topics' => $topicList
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
            'comments' => $commentList
            //'comments' => Topic::find($id)->comments
        ]);
    }
}
