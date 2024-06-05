<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCampusCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('campus_course', function (Blueprint $table) {
            $table->string('campusId')->nullable()->after('course_id');
            $table->string('campusName')->nullable()->after('campusId');
            $table->string('tuitionFee')->nullable()->after('campusName');
            $table->string('programCode')->nullable()->after('tuitionFee');
            $table->string('applicationFee')->nullable()->after('programCode');
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
        Schema::table('campus_course', function (Blueprint $table) {
            $table->drop('campusId');
            $table->drop('campusName');
            $table->drop('tuitionFee');
            $table->drop('programCode');
            $table->drop('applicationFee');
        });
    }
}
