<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aqis', function (Blueprint $table) {
            $table->id();
            $table->string('station_name');
            $table->integer('aqi');
            $table->string('time');
            $table->integer('humidity')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('atmospheric_pressure')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aqis');
    }
};
