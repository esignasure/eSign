<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserParentDirectoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_parent_directory', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_directory_id')->comment('This is the id of directory itself form the user directory table');
            $table->foreign('user_directory_id')->references('id')->on('user_directory');
            $table->unsignedInteger('user_parent_directory_id')->comment('This is the id of parent directory from the user directory table');
            $table->foreign('user_parent_directory_id')->references('id')->on('user_directory');
            $table->softDeletes();
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
        Schema::dropIfExists('user_parent_directory');
    }
}
