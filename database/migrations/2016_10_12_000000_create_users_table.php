<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password', 60);
            $table->string('avatar')->default('noavatar.jpg');
            $table->string('cover')->default('nocover.jpg');
            $table->string('facebook_id')->unique()->nullable();
            $table->string('twitter_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->integer('status')->default(0);
            $table->integer('level')->default(0);
            $table->string('facebook_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
