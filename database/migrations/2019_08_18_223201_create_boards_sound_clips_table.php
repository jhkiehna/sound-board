<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsSoundClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards_sound_clips', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('board_id')->unsigned();
            $table->bigInteger('sound_clip_id')->unsigned();

            $table->timestamps();

            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
            $table->foreign('sound_clip_id')->references('id')->on('sound_clips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards_sound_clips');
    }
}
