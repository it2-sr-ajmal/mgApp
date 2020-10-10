<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('post_id', true);
            $table->string('post_slug', 255);
            $table->string('post_type', 255)->nullable();
            $table->integer('post_parent_id')->nullable()->default(0);
            $table->integer('post_category_id')->nullable();
            $table->string('post_title', 255);
            $table->string('post_title_arabic', 255)->nullable();
            $table->string('post_image', 255)->nullable();
            $table->string('post_image_arabic', 255)->nullable();
            $table->integer('post_status');
            $table->integer('post_priority')->nullable();
            $table->integer('post_set_as_banner')->nullable()->default(2)->comment('1- yes 2-no');
            $table->dateTime('post_created_datetime')->nullable();
            $table->dateTime('post_updated_datetime')->nullable();
            $table->integer('post_created_by');
            $table->integer('post_updated_by');
            $table->dateTime('post_created_at');
            $table->dateTime('post_updated_at');
            $table->softDeletes();
            $table->unique(['post_slug', 'post_type'], 'post_slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
