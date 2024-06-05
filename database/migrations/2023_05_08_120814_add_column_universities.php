<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUniversities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('universities', function (Blueprint $table) {
            $table->string('institutionId')->nullable()->after('name');
            $table->string('shoreType')->nullable()->after('institutionId');
            $table->string('is_pgwp')->nullable()->after('shoreType');
            $table->string('is_public')->nullable()->after('is_pgwp');
            $table->string('institutionType')->nullable()->after('is_public');
            $table->string('institutionUrl')->nullable()->after('institutionType');
            $table->string('programCount')->nullable()->after('logo');
            $table->string('campusName')->nullable()->after('programCount');
            $table->string('openIntake')->nullable()->after('campusName');
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
        Schema::table('universities', function (Blueprint $table) {
            $table->drop('institutionId');
            $table->drop('shoreType');
            $table->drop('is_pgwp');
            $table->drop('is_public');
            $table->drop('institutionType');
            $table->drop('institutionUrl');
            $table->drop('logo');
            $table->drop('programCount');
            $table->drop('campusName');
            $table->drop('openIntake');
        });
    }
}
