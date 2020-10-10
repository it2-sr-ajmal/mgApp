<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_media', function (Blueprint $table) {
            $table->integer('pm_id', true);
            $table->integer('pm_post_id')->nullable();
            $table->string('pm_lang', 2)->nullable();
            $table->string('pm_media_type', 255)->nullable()->default('image');
            $table->string('pm_cat', 255)->nullable();
            $table->string('pm_name', 255)->nullable();
            $table->string('pm_title', 255)->nullable();
            $table->string('pm_title_arabic', 255)->nullable();
            $table->string('pm_source', 255)->nullable();
            $table->string('pm_source_arabic', 255)->nullable();
            $table->string('pm_orig_name', 255)->nullable();
            $table->string('pm_file_hash', 255)->nullable();
            $table->integer('pm_owner_id')->nullable();
            $table->string('pm_file_type', 255)->nullable();
            $table->string('pm_extension', 255)->nullable();
            $table->string('pm_size', 255)->nullable();
            $table->dateTime('pm_created_at');
            $table->dateTime('pm_update_at')->nullable();
            $table->integer('pm_priority')->default(1);
            $table->integer('pm_status')->default(1)->comment('1- Publi, 2- PRovate');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_media');
    }
}
