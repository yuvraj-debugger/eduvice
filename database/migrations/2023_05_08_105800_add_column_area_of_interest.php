<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAreaOfInterest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('area_of_interest', function (Blueprint $table) {
            $table->string('position')->nullable()->after('title');
            $table->string('has_icon')->nullable()->after('position');
            $table->string('icon_png')->nullable()->after('has_icon');
            $table->string('icon_png_high')->nullable()->after('icon_png');
            $table->string('is_selected')->nullable()->after('icon_png_high');
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
        Schema::table('area_of_interest', function (Blueprint $table) {
            $table->drop('title');
            $table->drop('position');
            $table->drop('has_icon');
            $table->drop('icon_png');
            $table->drop('icon_png_high');
        });
    }
}
