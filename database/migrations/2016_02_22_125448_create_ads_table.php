<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table){
            $table->increments('id');
            $table->text('home_top_ad_code');
            $table->string('home_top_ad_img');

            $table->text('home_side_ad_code');
            $table->string('home_side_ad_img');

            $table->text('media_top_ad_code');
            $table->string('media_top_ad_img');

            $table->text('media_bottom_ad_code');
            $table->string('media_bottom_ad_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Shema::drop('ads');
    }
}
