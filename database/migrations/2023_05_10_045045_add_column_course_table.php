<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCourseTable extends Migration
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
            $table->text('ielts')->nullable()->after('key_highlight');
            $table->text('toefl')->nullable()->after('ielts');
            $table->text('pte')->nullable()->after('toefl');
            $table->text('duolingo')->nullable()->after('pte');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course', function (Blueprint $table) {
            $table->drop('ielts');
            $table->drop('toefl');
            $table->drop('pte');
            $table->drop('duolingo');
        });
        
    }
}
