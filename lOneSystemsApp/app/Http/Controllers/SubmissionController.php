<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Survey;
use App\Mail\NewSubmission;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

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

        $survey = Survey::findOrFail($request->input("SurveyId"));
        if(isset($survey->email)){
            Mail::to($survey)->queue(new NewSubmission($answers,$survey->Title));
            // Mail::to($survey)->queue(new NewSubmission());

        }
        return response()->json([
            'success' => true,
            'message' => 'new submisstion',
            'submissions' => $submission->questions,
            'answers' => $answers,

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

    


    /**
     * get number of submissions per month
     * @param $year
     * 
     */
    public function getSubmissionsPerMonth(){
        
        // $number_month =Submission::select(
        //     DB::raw('count(*) as numberOfSumbission'),
        //     DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"),

        // )
        // ->whereYear('created_at', date('2021'))
        // ->groupBy('month')
        // ->orderBy('created_at', 'DESC')
        // ->limit(1);

        
        $number_month =Submission::select(
            DB::raw('count(*) as count'),
            DB::raw("DATE_FORMAT(created_at,'%b %Y') as monthYear"),
        )
        ->groupBy('monthYear')
        ->latest()
        ->take(12)->get();

        $submissionsCounter = array();
        $monthYearOfSumbission= array();
        foreach($number_month as $nm){
            $submissionsCounter[] = $nm->count;
            $monthYearOfSumbission[] = $nm->monthYear;

        }
       
        return response()->json([
            'success' => true,
            'message' => 'Submissions Per Month',
            'submissionsCounter' => array_reverse($submissionsCounter),
            'monthYearOfSumbission' => array_reverse($monthYearOfSumbission)
        ]); 


        // return response()->json([
        //     'success' => true,
        //     'message' => 'Submissions Per Month',
        //     'submissionsCounter' => json_encode($numberOfSubmissionString,JSON_NUMERIC_CHECK),
        //     'monthYearOfSumbission' => json_encode($monthYearOfSumbission,JSON_NUMERIC_CHECK)
        // ]); 

        
    }





    public function getSubmissionsPerSurvey(){
        $allSurveys = Survey::with("submissions")->get();

        $surveysTitles = array();
        $surveysNumberOfSubmissions = array();
        foreach($allSurveys as $survey){
            $surveysTitles[] = $survey->Title;
            $surveysNumberOfSubmissions[] = sizeof($survey->submissions);
        }

         return response()->json([
            'success' => true,
            'message' => 'Submissions Per survey',
            'surveysTitles' => $surveysTitles,
            'surveysNumberOfSubmissions' => $surveysNumberOfSubmissions
        ]); 

    }

}
