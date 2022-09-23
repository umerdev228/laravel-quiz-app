@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2>Quiz</h2>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-header">{{ __('Quizzes') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="list-group mb-4">
                            <a href="javascript:void(0)"
                               class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{$quiz->title}}</h5>
                                    <small>{{$quiz->created_at->diffForHumans()}}</small>
                                </div>
                                <p class="mb-1">{{$quiz->Description}}.</p>
                                <small>Total Marks. {{$quiz->marks}}</small>
                                <div class="d-flex w-100 justify-content-between">
                                    <small>Created By. {{$quiz->user->name}}</small>
                                    <small>Duration. {{$quiz->time}} mins</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @auth
                <example-component :quiz="{{json_encode($quiz)}}" :ans="{{json_encode($ans)}}" :result="{{json_encode($result)}}"></example-component>
            @endauth
        </div>
    </div>
@endsection
