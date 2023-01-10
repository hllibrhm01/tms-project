<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmsVehiclePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_vehicle_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vehicle_id");
            $table->unsignedTinyInteger("type");
            $table->mediumText("description")->nullable();
            $table->string("path" , 255);
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
        Schema::dropIfExists('tms_vehicle_papers');
    }
}
