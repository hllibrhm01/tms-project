<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('cities', function (blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger("country_id");
            $table->string('name' , 50);
            $table->timestamps();
        });

        schema::table('cities', function (blueprint $table) 
        {
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
