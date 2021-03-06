<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $guarded = ['id'];  

    // protected $casts = [
    //     "submissions.pivot.note" => "encrypted"
    // ];
    public function survey(){
        return $this->belongsTo("App\Models\Survey","SurveyId");
    }

    // public function questions(){
    //     return $this->belongsToMany("App\Models\Question","answers","SubmissionId","QuestionId")->withPivot("Answer","Note");
    // }

     public function questions(){
        return $this->belongsToMany("App\Models\Question","answers","SubmissionId","QuestionId")->using("App\Models\Answer")->withPivot("Answer","Note");
    }
    
}
