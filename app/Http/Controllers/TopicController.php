<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;

use App\Traits\ErrorTextTrait;
use App\Traits\UtilsTrait;

use App\Repositories\TopicRepositoryInterface;
use App\Repositories\CommentRepositoryInterface;



class TopicController extends Controller
{
    use ErrorTextTrait, UtilsTrait;

    private $topicRepository, $commentRepository;

    public function __construct(TopicRepositoryInterface $topicRepository, CommentRepositoryInterface $commentRepository) {
        $this->topicRepository = $topicRepository;
        $this->commentRepository = $commentRepository;
    }

    public function show(): View {

        $topicList = $this->topicRepository->getAllTopics();
        
        return view('topic.topics', [
            'topics' => $topicList,
            'isLogged' => Auth::check()
        ]);
    }

    public function showOne($id): View{
        $commentList = $this->commentRepository->findByTopicId($id);

        $isLogged = Auth::check();
        return view('topic.single_topic', [
            'topic' => $this->topicRepository->getSingleTopic($id),
            'comments' => $commentList,
            'isLogged' => $isLogged,
            'user_id' => $isLogged ? Auth::user()->id : 0,
            'isSuperUser' => $isLogged ? $this->isSuperUser() : 0
        ]);
    }

    public function createTopicView(): View{
        return view('topic.create_topic');
    }

    public function createTopic(Request $request) {
        $isValidTitle = $this->topicRepository->getTitleLengthCheck(['title' => $request->title]);
        $isValidText = $this->topicRepository->getTextLengthCheck(['topic_text' => $request->topic_text]);
        if(Auth::check() && $isValidTitle && $isValidText) {
            $topic = $this->topicRepository->createTopic([
                'title' => $request->title,
                'topic_text' => $request->topic_text,
                'user_id' => Auth::id()
            ]);

    
            return redirect('/topic/' . $topic->id);
        }
        
        return redirect('/topic/create/topic')->withErrors([
            'text_error' => $isValidText ? '' : $this->getTopicTextLengthError(),
            'title_error' => $isValidTitle ? '' : $this->getTopicTitleLengthError(),
        ])->withInput();
    }

    public function deleteTopic($topicId) {
        $topic = $this->topicRepository->getSingleTopic($topicId);
        $isValidUser = $this->checkValidAuthUser($topic->user_id);
        $isSuperUser = $this->isSuperUser();

        if(($isSuperUser || $isValidUser) && $topic) {
            $this->topicRepository->deleteTopic($topic);
        }
        
        return redirect('/');
    }

    public function editTopicView(Request $request, $topicId) {
        $topic = $this->topicRepository->getSingleTopic($topicId);
        $isSuperUser = $this->isSuperUser();
        $isValidUserId = $this->checkValidAuthUser($topic->user_id);
        if($isSuperUser || $isValidUserId) {
            return view('topic.edit_topic', [
                'topic' => $topic
            ]);
        } else {
            return back()->withErrors([
                'malicious_edit_error' => $this->getTopicMaliciousEdit(),
            ]);
        }        
    }

    public function editTopic(Request $request, $topicId){
        $isValidText = $this->topicRepository->getTextLengthCheck(['topic_text' => $request->text]);
        $topic = $this->topicRepository->getSingleTopic($topicId);
        $isValidTitle = $this->topicRepository->getTitleLengthCheck(['title' => $request->title]);
        $isValidUserId = $this->checkValidAuthUser($topic->user_id);
        $isSuperUser = $this->isSuperUser();
         
        if(($isSuperUser || $isValidUserId) && $isValidText && $isValidTitle) {
            $this->topicRepository->update($topic, [
                'topic_text' => $request->text,
                'title' => $request->title
            ]);
            return redirect('/topic/' . $topicId);
        }
        return back()->withErrors([
            'text_error' => $isValidText ? $this->getGenericError() : $this->getTopicTextLengthError(),
            'title_error' => $isValidTitle ? $this->getGenericError() : $this->getTopicTitleLengthError()
        ]);
    }
}
