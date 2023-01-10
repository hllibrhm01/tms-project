<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TmsVehicleExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_vehicle_expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->unsignedBigInteger("vehicle_id");
            $table->unsignedInteger("employee_count");
            $table->unsignedInteger("missing_employee_count");
            $table->unsignedInteger("overtimer_employee_count");
            $table->time("work_finish_time");
            $table->unsignedDouble("driven_km");
            $table->unsignedDouble("fuel_taken_per_litre");
            $table->unsignedDouble("fuel_taken_with_tl");
            $table->unsignedDouble("fuel_consumption_per_km");
            $table->unsignedDouble("fuel_consumption_percentage_per_km");
            $table->unsignedDouble("rental_cost");
            $table->unsignedDouble("employee_cost");
            $table->unsignedDouble("daily_meal_cost");
            $table->unsignedDouble("daily_overtime_meal_cost");
            $table->unsignedDouble("highway_expenses");
            $table->unsignedDouble("day_laborer");
            $table->unsignedDouble("supplies_cost");
            $table->unsignedDouble("total_cost");
            $table->unsignedDouble("total_revenue");
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
        Schema::dropIfExists('tms_vehicle_expenses');
    }
}
