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
        $surveys= Survey::all();
        return response()->json([
            'success' => true,
            'message' => 'List of All surveys',
            'surveys' => $surveys,
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
        $validatedRequest = $request->validate([
            "Title" => "required|max:255",
            "Questions" => "required",
        ]);
        
        $email= $request->input("Email");
        if(isset($email))
        {
            $newSurvey = Survey::create([
                "Title" => $request->input("Title"),
                "email" => $email
            ]);
        }
        else {
            $newSurvey = Survey::create([
                "Title" => $request->input("Title"),
            ]);
        }

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
    public function show($id)
    {
        //
        $survey= Survey::with("submissions.questions")->findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'one survey with submissions',
            'survey' => $survey,
        ]); 
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

    /**
     * 
     * get survey's first question
     * @param $SurveyId
     * @return \Illuminate\Http\Response
     * 
     */
    public function getFirstQuestion($id){
        $question = Question::where("SurveyId","=",$id)->first();
        return response()->json([
            'success' => true,
            'message' => 'first question',
            'question' => $question,
            'id' => $id
        ]); 
    }

    public function getNextQuestion($surveyId,$questionId){
        try {
            $question = Question::where("SurveyId","=",$surveyId)->findOrFail($questionId);
            return response()->json([
                'success' => true,
                'message' => 'next question',
                'question' => $question,
            ]); 
        }
        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json([
                'success' => false,
                'message' => 'end of survey',
            ]); 
        }
        

    }
}
