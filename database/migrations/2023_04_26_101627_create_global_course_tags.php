<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalCourseTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_course_tags', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->unsignedBigInteger('global_course_id')->index();
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
        Schema::dropIfExists('global_course_tags');
    }
}
