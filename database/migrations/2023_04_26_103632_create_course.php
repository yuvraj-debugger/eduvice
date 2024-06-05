<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->integer('university_id');
            $table->integer('global_course_id');
            $table->string('title');
            $table->string('intake');
            $table->string('duration_number')->nullable();
            $table->string('duration_day')->nullable();
            $table->string('duration_month')->nullable();
            $table->string('duration_year')->nullable();
            $table->string('tution_fee_currency')->nullable();
            $table->string('tution_fee_amount')->nullable();
            $table->string('application_fee_currency')->nullable();
            $table->string('application_fee_amount')->nullable();
            $table->date('open_intake');
            $table->text('key_highlight')->nullable();
            $table->text('eligibility_criteriat')->nullable();
            $table->integer('status')->default(1);
            $table->integer('type')->default(0);
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('course');
    }
}
