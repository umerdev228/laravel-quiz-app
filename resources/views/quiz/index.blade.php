@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2>Quizzes</h2>
                    @auth
                    <a class="btn btn-success" href="{{route('quiz.create')}}">Create Quiz</a>
                    @endauth
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Quizzes') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="list-group mb-4">
                                @foreach($quizzes as $quiz)
                                <a href="{{route('quiz.show', $quiz->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$quiz->title}}</h5>
                                        <small>{{$quiz->created_at->diffForHumans()}}</small>
                                    </div>
                                    <p class="mb-1">{{$quiz->Description}}.</p>
                                    <small>Created By. {{$quiz->user->name}}</small>
                                </a>
                                @endforeach

                            </div>
                            {{ $quizzes->links() }}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
