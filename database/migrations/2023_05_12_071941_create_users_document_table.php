<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_document', function (Blueprint $table) {
            $table->id();
            $table->string('university_id');
            $table->string('campus_id');
            $table->string('english_test_doc')->nullable();
            $table->string('degree_doc')->nullable();
            $table->string('cv_experienced_doc')->nullable();
            $table->string('passport_number')->nullable();
            $table->text('sop')->nullable();
            $table->string('lor')->nullable();
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
        Schema::dropIfExists('users_document');
    }
}
