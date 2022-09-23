@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create Quiz') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('quiz.store') }}" id="quiz-form">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="col-md-4 col-form-label">{{ __('Title') }}</label>
                                <div class="col-md-12">
                                    <input id="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror" name="title"
                                           value="{{ old('title') }}" required autocomplete="title" autofocus>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="col-md-4 col-form-label">{{ __('Description') }}</label>
                                <div class="col-md-12">
                                    <textarea id="description" type="text"
                                              class="form-control @error('description') is-invalid @enderror"
                                              name="description" required autocomplete="description"
                                              autofocus>{{ old('title') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="num_of_questions"
                                       class="col-md-4 col-form-label">{{ __('Number of Questions') }}</label>
                                <div class="col-md-12">
                                    <input onchange="numberOfQuestions()" id="num_of_questions" type="number" min="1"
                                           class="form-control @error('num_of_questions') is-invalid @enderror"
                                           name="num_of_questions" value="{{ old('num_of_questions') }}" required
                                           autocomplete="num_of_questions" autofocus>
                                    @error('num_of_questions')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="num_of_answers"
                                       class="col-md-4 col-form-label">{{ __('Number of answer options each question') }}</label>
                                <div class="col-md-12">
                                    <input onchange="numberOfQuestions()" id="num_of_answers" type="number" min="2"
                                           max="4" class="form-control @error('num_of_answers') is-invalid @enderror"
                                           name="num_of_answers" value="{{ old('num_of_answers') }}" required
                                           autocomplete="num_of_answers" autofocus>
                                    @error('num_of_answers')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="col-md-4 col-form-label">{{ __('Time (Minutes)') }}</label>
                                <div class="col-md-12">
                                    <input id="time" type="number" min="1" max="60"
                                           class="form-control @error('time') is-invalid @enderror" name="time"
                                           value="{{ old('time') }}" required autocomplete="time" autofocus>
                                    @error('time')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="marks" class="col-md-4 col-form-label">{{ __('Total Mark') }}</label>
                                <div class="col-md-12">
                                    <input id="marks" type="number"
                                           class="form-control @error('marks') is-invalid @enderror" name="marks"
                                           value="{{ old('marks') }}" required autocomplete="marks" autofocus>
                                    @error('marks')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col" id="question-answers">
                                <h2>Questions Answers</h2>
                            </div>


                            <div class="row mb-0">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('/js/quiz/index.js')}}"></script>
