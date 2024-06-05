<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education_detail', function (Blueprint $table) {
            $table->id();
            $table->string('class')->nullable();
            $table->string('mark_grade')->nullable();
            $table->string('passing_year')->nullable();
            $table->integer('type')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
            $table->integer('created_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_education_detail');
    }
}
