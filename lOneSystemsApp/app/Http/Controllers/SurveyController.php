<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;

use Illuminate\Http\Request;

class SurveyController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            "Title" => "required|max:255",
            "Questions" => "required",
        ]);
        
        $newSurvey = Survey::create([
            "Title" => $request->input("Title")
        ]);

        $questions = json_decode($request->input("Questions"));
        foreach($questions as  $question){
           
            $newQuestion = Question::create([
                "SurveyId" => $newSurvey->id,
                "Body" => $question->body,

            ]);

            if($question->yesQuestion){
                $yesQuestion = Question::create([
                    "SurveyId" => $newSurvey->id,
                    "Body" => $question->yesQuestion
                ]);
                $newQuestion->YesQuestionId = $yesQuestion->id;
                $newQuestion->save();
                
            }
            if($question->noQuestion){
                $noQuestion = Question::create([
                    "SurveyId" => $newSurvey->id,
                    "Body" => $question->noQuestion
                ]);
                $newQuestion->NoQuestionId = $noQuestion->id;
                $newQuestion->save();
            }


        }
        return response()->json([
            'success' => true,
            'message' => "added new survey",
            'survey' => $newSurvey->with("questions")
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
