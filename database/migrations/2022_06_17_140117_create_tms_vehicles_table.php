<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMSVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('dedicated_customer_id')->nullable();
            $table->string('relations_name_surname');
            $table->string('relations_phone');
            $table->string('degree_of_proximity');
            $table->string('trademark');
            $table->string('model');
            $table->string('licence_plate');
            $table->unsignedInteger('model_date');
            $table->string('fixed_address')->nullable();;
            $table->unsignedBigInteger('kilometer');
            $table->unsignedTinyInteger('ownership');
            $table->unsignedBigInteger('care_kilometer');
            $table->date('inspection_date');
            $table->unsignedDouble('average_fuel_consumption');
            $table->unsignedDouble('capacity');
            $table->unsignedDouble('width');
            $table->unsignedDouble('size');
            $table->unsignedDouble('height');
            $table->boolean('vehicle_tracking_system');
            $table->boolean('vehicle_recognition');
            $table->boolean('maintenance_agreement_signature');
            $table->boolean('embezzlement_form');
            $table->boolean('service_description');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('tms_vehicles');
    }
}
