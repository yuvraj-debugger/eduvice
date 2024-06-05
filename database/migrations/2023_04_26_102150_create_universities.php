<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('country');
            $table->string('admission_contact_person');
            $table->string('admission_contact_number',11);
            $table->string('admission_email',100);
            $table->string('admission_website');
            $table->string('placement_contact_person');
            $table->string('placement_contact_number',11);
            $table->string('placement_email',100);
            $table->string('placement_website');
            $table->text('about')->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('universities');
    }
}
