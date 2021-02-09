<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("SubmissionId");
            $table->unsignedBigInteger("QuestionId");
            $table->boolean("Answer");
            $table->text("Note")->nullable();
            $table->timestamps();
            $table->foreign("SubmissionId")->references("id")->on("submissions")->onDelete("cascade");
            $table->foreign("QuestionId")->references("id")->on("questions")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
