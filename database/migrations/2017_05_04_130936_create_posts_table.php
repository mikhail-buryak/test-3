<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            // Add columns
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->comment('post user fk');
            $table->string('title', 200)->comment('post title');
            $table->text('body')->comment('post body(description)');
            $table->string('image_cover', 255)->nullable()->comment('post small image source');
            $table->string('image_full', 255)->nullable()->comment('post full image source');
            $table->jsonb('tags')->nullable()->comment('post tags');
            $table->timestamps();

            // Add indexes
            $table->index('title');
            $table->index('tags');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
