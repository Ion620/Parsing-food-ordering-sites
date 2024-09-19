<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments_to_parsers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('establishment_id')->unsigned();
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->integer('parser_id')->unsigned();
            $table->foreign('parser_id')->references('id')->on('parsers');
            $table->json('options');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments_to_parsers');
    }
};
