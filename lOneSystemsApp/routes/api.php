<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubmissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'surveys' => SurveyController::class,
    'questions' => QuestionController::class,
    'submissions' => SubmissionController::class
   
]);

Route::get("/surveys/{id}/getFirstQuestion",[SurveyController::class, 'getFirstQuestion']);
Route::get("/surveys/{surveyId}/questions/{questionId}",[SurveyController::class, 'getNextQuestion']);


// charts routes
Route::get("/getSubmissionsPerMonth",[SubmissionController::class, 'getSubmissionsPerMonth']);
Route::get("/getSubmissionsPerSurvey",[SubmissionController::class, 'getSubmissionsPerSurvey']);

