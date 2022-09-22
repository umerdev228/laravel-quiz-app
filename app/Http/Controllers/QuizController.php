<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use Illuminate\Http\Request;


class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $quizzes = Quiz::with(['user'])->paginate(8);
        return view('quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuizRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'num_of_questions' => 'required|integer',
            'num_of_answers' => 'required|integer',
            'time' => 'required|integer',
            'marks' => 'required|integer',
        ]);
        $quiz = Quiz::create([
            'title' => $request->title,
            'user_id' => 1,
            'description' => $request->description,
            'num_of_questions' => $request->num_of_questions,
            'num_of_answers' => $request->num_of_answers,
            'time' => $request->time,
            'marks' => $request->marks,
            'per_question_marks' => $request->marks / $request->num_of_questions,
        ]);
        for ($i = 0; $i < $request->num_of_questions; $i++) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question' => $request['question-'.($i)],
            ]);
            for ($j = 0; $j < $request->num_of_answers; $j++) {
                Answer::create([
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'answer' => $request['answer-'.($i).'-'.$j],
                    'is_correct' => (integer)$request['answer-correct-'.($i)] === ($j+1),
                ]);
            }
        }
        return redirect()->route('quiz.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuizRequest  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
