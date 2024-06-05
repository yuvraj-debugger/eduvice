<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('profile_photo_path');
            $table->string('gender','10')->after('date_of_birth');
            $table->string('martial_status','20')->after('gender');
            $table->string('contact','14')->after('martial_status');
            $table->string('address')->after('contact');
            $table->string('state')->after('address');
            $table->string('pincode')->after('state');            
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('martial_status');
            $table->dropColumn('contact');
            $table->dropColumn('address');
            $table->dropColumn('state');
            $table->dropColumn('pincode');
        });
    }
}
