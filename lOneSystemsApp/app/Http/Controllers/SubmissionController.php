<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $submissions= Submission::all();
        return response()->json([
            'success' => true,
            'message' => 'List of All submissions',
            'submissions' => $submissions,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedRequest = $request->validate([
            "Answers" => "required",
            "SurveyId" => "required"
        ]);

        $submission = Submission::create([
            "Title" => "Submisstion:" .  Str::uuid(),
            "SurveyId" => $request->input("SurveyId")
        ]);

        $answers = json_decode($request->input("Answers"));
        foreach($answers as $answer){
            $submission->questions()->attach($answer->QuestionId,["Note" => $answer->Note , "Answer" => $answer->Answer]);
        }

        return response()->json([
            'success' => true,
            'message' => 'new submisstion',
            'submissions' => $submission->questions(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
