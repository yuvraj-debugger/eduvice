<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableBlogPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('feature_image');
            $table->integer('parent_id')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('slug');
            $table->tinyText('summary')->nullable();
            $table->text('content')->nullable();
            $table->integer('created_by');
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
        Schema::table('blog_post', function (Blueprint $table) {
            Schema::dropIfExists('blog_post');
        });
    }
}
