<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/quiz/results', [App\Http\Controllers\QuizController::class, 'getResults']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/quiz', [App\Http\Controllers\QuizController::class, 'index'])->name('quiz.index');
Route::get('/quiz/create', [App\Http\Controllers\QuizController::class, 'create'])->name('quiz.create');
Route::post('/quiz/store', [App\Http\Controllers\QuizController::class, 'store'])->name('quiz.store');
Route::get('/quiz/{quiz}', [App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/answer/submit', [App\Http\Controllers\QuizController::class, 'submitChooseAnswer']);
