<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $guarded = ['id'];  

    public function questions(){
        return $this->hasMany("App\Models\Question","SurveyId");
    }

    public function submissions(){
        return $this->hasMany("App\Models\Submission","SurveyId");
    }

}
