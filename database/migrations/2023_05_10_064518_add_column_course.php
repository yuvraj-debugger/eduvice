<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('course', function (Blueprint $table) {
            $table->integer('programId')->nullable()->after('global_course_id');
            $table->integer('institutionId')->nullable()->after('programId');
            $table->string('currencySymbol')->nullable()->after('institutionId');
            $table->string('currencyCode')->nullable()->after('currencySymbol');
            $table->string('countryName')->nullable()->after('currencyCode');
            $table->string('isShortlisted')->nullable()->after('countryName');
            $table->string('programUrl')->nullable()->after('isShortlisted');
            $table->string('duration')->nullable()->after('programUrl');
            $table->string('programName')->nullable()->after('duration');
            $table->string('hasLogo')->nullable()->after('programName');
            $table->string('logo')->nullable()->after('hasLogo');
            $table->string('min_requirement')->nullable()->after('logo');
            $table->string('note')->nullable()->after('min_requirement');
            $table->string('institutionName')->nullable()->after('note');;
            $table->text('campusDetails')->nullable()->after('institutionName');
            $table->text('openIntake')->nullable()->after('campusDetails');
            $table->text('intakeDetails')->nullable()->after('openIntake');
            $table->text('etsDetails')->nullable()->after('intakeDetails');
            $table->integer('study_level_id')->nullable()->after('etsDetails');
            $table->integer('discipline_id')->nullable()->after('study_level_id');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('course', function (Blueprint $table) {
            $table->drop('programId');
            $table->drop('institutionId');
            $table->drop('currencySymbol');
            $table->drop('currencyCode');
            $table->drop('countryName');
            $table->drop('isShortlisted');
            $table->drop('programUrl');
            $table->drop('duration');
            $table->drop('programName');
            $table->drop('hasLogo');
            $table->drop('logo');
            $table->drop('min_requirement');
            $table->drop('note');
            $table->drop('institutionName');
            $table->drop('campusDetails');
            $table->drop('openIntake');
            $table->drop('intakeDetails');
            $table->drop('etsDetails');
            $table->drop('study_level_id');
            $table->drop('discipline_id');
        });
    }
}
