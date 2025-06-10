<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEspeceParticipant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espece_participant', function($table) {

          $table->integer('espece_id')->unsigned()->index();

          $table->foreign('espece_id')->references('id')->on('especes')->onDelete('cascade');

          $table->integer('participant_id')->unsigned()->index();

          $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');

          $table->primary(['espece_id', 'participant_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('espece_participant');
    }
}
