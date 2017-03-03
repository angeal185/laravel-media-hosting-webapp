<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table){
            $table->increments('id');
            $table->string('short_url');
            $table->integer('user_id');
            $table->integer('category_id')->default(1);
            $table->string('title');
            $table->string('description', 250);
            $table->integer('active')->default(1);
            $table->integer('is_video')->default(0);
            $table->integer('is_picture')->default(1);
            $table->text('pic_url')->nullable();
            $table->text('vid_url')->nullable();
            $table->string('vid_type')->nullable();
            $table->text('vid_img')->nullable();
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
        Schema::drop('media');
    }
}
