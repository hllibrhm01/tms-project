<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        { 
            Schema::create('wms_locations', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('country')->default(1);
                $table->unsignedInteger('city_id');
                $table->unsignedInteger('district_id');
                $table->mediumText('address_description');
                $table->string('authorized_person');
                $table->string('email');
                $table->string('phone');
                $table->unsignedInteger('capacity');
                $table->timestamps();
            });
    
            Schema::table('wms_locations', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wms_locations');
    }
}
