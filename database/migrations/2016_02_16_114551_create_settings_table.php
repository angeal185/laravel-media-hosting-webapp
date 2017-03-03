<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table){
            $table->increments('id');
            $table->string('website_name');
            $table->string('website_description');
            $table->string('title_description');
            $table->string('website_keywords');
            $table->string('website_email');
            $table->integer('adblock_detecting');
            $table->integer('auto_approve_comments');
            $table->string('logo')->default('nologo.png');
            $table->string('favicon')->default('nofavicon.png');
            $table->string('facebook_page_id');
            $table->string('google_page_id');
            $table->string('twitter_page_id');
            $table->integer('auto_approve_posts');
            $table->integer('paginate')->default(9);
            $table->integer('recaptcha')->default(0);
            $table->integer('allow_vid_up')->default(0);
            $table->integer('max_vid_mb')->default(100);
            $table->integer('max_img_mb')->default(3);
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
        Schema::drop('settings');
    }
}
