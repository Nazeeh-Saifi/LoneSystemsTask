<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSubmission extends Mailable
{
    use Queueable, SerializesModels;

    protected $answers;
    protected $surveyTitle;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($answers,$surveyTitle)
    {
        //
        $this->answers = $answers;
        $this->surveyTitle = $surveyTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.newsubmission')
        ->with([
            "answers"=> $this->answers,
            "surveyTitle" => $this->surveyTitle
        ]);
    }
}
