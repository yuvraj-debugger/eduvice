<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_score', function (Blueprint $table) {
            $table->id();
            $table->string('test_score')->nullable();
            $table->string('reading')->nullable();
            $table->string('writing')->nullable();
            $table->string('listening')->nullable();
            $table->string('speaking')->nullable();
            $table->string('overall')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('test_score');
    }
}
