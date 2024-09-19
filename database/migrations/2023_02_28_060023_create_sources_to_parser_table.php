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
        Schema::create('sources_to_parser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('sources');
            $table->foreignId('parser_id')->constrained('parsers');
            $table->unique(['source_id', 'parser_id']);
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
        Schema::dropIfExists('sources_to_parser');
    }
};
