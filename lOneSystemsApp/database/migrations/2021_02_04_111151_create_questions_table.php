<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("SurveyId");
            $table->string("Body");
            $table->unsignedBigInteger("YesQuestionId")->nullable();
            $table->unsignedBigInteger("NoQuestionId")->nullable();
            $table->foreign("SurveyId")->references("id")->on("surveys")->onDelete("cascade");
            $table->foreign("YesQuestionId")->references("id")->on("questions")->onDelete("cascade");
            $table->foreign("NoQuestionId")->references("id")->on("questions")->onDelete("cascade");
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
