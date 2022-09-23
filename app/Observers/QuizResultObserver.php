<?php

namespace App\Observers;

use App\Mail\DailyQuizDigest;
use App\Models\QuizResult;
use Hmones\LaravelDigest\Facades\Digest;

class QuizResultObserver
{
    /**
     * Handle the QuizResult "created" event.
     *
     * @param  \App\Models\QuizResult  $quizResult
     * @return void
     */
    public function created(QuizResult $quizResult)
    {
        $batchId = 'QuizAttempted';
        $mailable = DailyQuizDigest::class;
        $data['quiz'] = json_decode(json_encode($quizResult, true));
        // Frequency can take values such as:
        // daily, weekly, monthly, custom, or an
        // integer threshold (10, 20, 30, etc.)
        $frequency = 'daily';

        Digest::add($batchId, $mailable, $data, $frequency);
    }

    /**
     * Handle the QuizResult "updated" event.
     *
     * @param  \App\Models\QuizResult  $quizResult
     * @return void
     */
    public function updated(QuizResult $quizResult)
    {
        //
    }

    /**
     * Handle the QuizResult "deleted" event.
     *
     * @param  \App\Models\QuizResult  $quizResult
     * @return void
     */
    public function deleted(QuizResult $quizResult)
    {
        //
    }

    /**
     * Handle the QuizResult "restored" event.
     *
     * @param  \App\Models\QuizResult  $quizResult
     * @return void
     */
    public function restored(QuizResult $quizResult)
    {
        //
    }

    /**
     * Handle the QuizResult "force deleted" event.
     *
     * @param  \App\Models\QuizResult  $quizResult
     * @return void
     */
    public function forceDeleted(QuizResult $quizResult)
    {
        //
    }
}
