<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
//use App\Question; 引入QuestionRepository model和controller分开
use App\Repositories\QuestionRepository;
//use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class QuestionsController
 * @package App\Http\Controllers
 */
class QuestionsController extends Controller
{
    /**
     * @var
     */
    protected $questionRepository;

    /**
     * QuestionsController constructor.
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
//        $rules = [
//            'title' => 'required|min:6|max:196',
//            'body' => 'required|min:16',
//        ];
//        $message = [
//            'title.required' => '标题不能为空',
//            'title.min' => '标题不能少于6个字',
//            'body.required' => '内容不能为空',
//            'body.min' => ' 内容不能少于10个字'
//        ];
//        $this->validate($request,$rules,$message);
        $topics = $this->questionRepository->normalize(($request->get('topics')));
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];

        $question = $this->questionRepository->create($data);
        $question->topics()->attach($topics);
        return redirect()->route('questions.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $question = Question::where('id',$id)->with('topics')->first();
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalize(($request->get('topics')));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topics()->sync($topics);//保留已有的 改变所改变的
        return redirect()->route('questions.show',[$question->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question)){
            $question->delete();

            return redirect('/');
        }
        abort(403, 'Forbidden');
    }


}
