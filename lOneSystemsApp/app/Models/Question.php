<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id'];  

    public function survey(){
        return $this->belongsTo("App\Models\Survey","SurveyId");
    }

    public function submissions(){
        return $this->belongsToMany("App\Models\Submission","answers","QuestionId","SubmissionId")->withPivot("Answer","Note");
    }
}
