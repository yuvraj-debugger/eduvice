<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseEstDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_est_detail', function (Blueprint $table) {
            $table->id();
            $table->string('score');
            $table->string('min_score')->nullable();
            $table->string('scoreName');
            $table->string('university_id')->default(0);
            $table->string('course_id')->default(0);
            $table->string('programId')->default(0);
            $table->integer('status')->default(1);
            $table->integer('type')->default(0);
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
        Schema::dropIfExists('course_est_detail');
    }
}
