<?php

namespace App\Http\Controllers;

use App\Models\SelectedAnswer;
use App\Http\Requests\StoreSelectedAnswerRequest;
use App\Http\Requests\UpdateSelectedAnswerRequest;

class SelectedAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSelectedAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSelectedAnswerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SelectedAnswer  $selectedAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(SelectedAnswer $selectedAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SelectedAnswer  $selectedAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(SelectedAnswer $selectedAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSelectedAnswerRequest  $request
     * @param  \App\Models\SelectedAnswer  $selectedAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSelectedAnswerRequest $request, SelectedAnswer $selectedAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SelectedAnswer  $selectedAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(SelectedAnswer $selectedAnswer)
    {
        //
    }
}
