<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggableTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taggable_taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('taggable_id');
            $table->string('taggable_type')->index('i_taggable_type');
            $table->timestamps();
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->index(['taggable_id', 'tag_id'], 'i_taggable_rev');
            $table->index(['tag_id', 'taggable_id'], 'i_taggable_fwd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggable_taggables');
    }
}
