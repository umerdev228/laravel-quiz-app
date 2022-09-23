<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\QuizResult;
use App\Models\SelectedAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
     * @param \App\Http\Requests\StoreQuizRequest $request
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
            'user_id' => Auth::id(),
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
                'question' => $request['question-' . ($i)],
            ]);
            for ($j = 0; $j < $request->num_of_answers; $j++) {
                Answer::create([
                    'quiz_id' => $quiz->id,
                    'question_id' => $question->id,
                    'answer' => $request['answer-' . ($i) . '-' . $j],
                    'is_correct' => (integer)$request['answer-correct-' . ($i)] === ($j + 1),
                ]);
            }
        }
        return redirect()->route('quiz.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Quiz $quiz)
    {
        $ans = SelectedAnswer::where('user_id', Auth::id())->where('quiz_id', $quiz->id)->get();
        $result = QuizResult::where('user_id', Auth::id())->where('quiz_id', $quiz->id)->first();
        return view('quiz.detail', compact('quiz', 'ans', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        dd($quiz);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateQuizRequest $request
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }

    public function getQuizQuestions(Request $request): \Illuminate\Http\JsonResponse
    {
//        $quiz = DB::table('quizzes')->where('id', $request->quiz_id)->first();
        $questions = DB::table('questions')->where('quiz_id', $request->quiz_id)->get();
        $answers = Answer::where('quiz_id', $request->quiz_id)->get();
        $ques = [];
        foreach ($questions as $index => $q) {
            $ques[$index]['question'] = $q->question;
            $ques[$index]['id'] = $q->id;
            $filtered = $answers->filter(function ($ans) use ($q) {
                return $ans->question_id == $q->id;
            });
            $ques[$index]['answers'] = $filtered->toArray();
        }

        return response()->json([
//            'quiz' => $quiz,
//            'questions' => $questions,
//            'answers' => $answers,
            'ques' => $ques,
        ]);
    }

    public function submitChooseAnswer(Request $request)
    {
        $request->validate([
            'question' => 'integer',
            'answer' => 'integer',
        ]);
        $ans = Answer::where('id', $request->answer)->first();
        $ques = Quiz::where('id', $ans->quiz_id)->first()->per_question_marks;
        $answer = SelectedAnswer::firstOrCreate([
            'quiz_id' => $ans->quiz_id,
            'question_id' => $request->question,
            'user_id' => Auth::id(),
        ], [
            'answer_id' => $request->answer,
            'is_correct' => $ans->is_correct
        ]);
        $answer->answer_id = $request->answer;
        $answer->is_correct = $ans->is_correct;
        $answer->save();
        $answers = SelectedAnswer::where('quiz_id', $ans->quiz_id)->where('user_id', Auth::id())->where('is_correct', true)->get();

        $quiz = QuizResult::firstOrCreate([
            'quiz_id' => $ans->quiz_id,
            'user_id' => Auth::id(),
        ], [
            'marks' => $ques * count($answers),
        ]);
        $quiz->marks = $ques * count($answers);
        $quiz->save();
        return response()->json([
            'message' => 'Answer Submitted Successfully',
        ]);
    }

    public function getResults(Request $request): \Illuminate\Http\JsonResponse
    {
        $ans = SelectedAnswer::where('user_id', Auth::id())->where('quiz_id', $request->quiz_id)->get();
        $result = QuizResult::where('user_id', Auth::id())->where('quiz_id', $request->quiz_id)->first();
        return response()->json([
           'ans' => $ans,
           'result' => $result,
        ]);
    }
}
