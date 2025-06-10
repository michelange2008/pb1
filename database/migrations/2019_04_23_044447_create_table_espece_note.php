<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEspeceNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_espece_note', function (Blueprint $table) {
            $table->integer('espece_id')
                  ->unsigned()
                  ->index();
            $table->foreign('espece_id')
                  ->references('id')
                  ->on('especes')
                  ->onDelete('cascade');

            $table->integer('note_id')
                  ->unsigned()
                  ->index();
            $table->foreign('note_id')
                  ->references('id')
                  ->on('notes')
                  ->onDelete('cascade');

            $table->primary(['espece_id', 'note_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_espece_note');
    }
}
