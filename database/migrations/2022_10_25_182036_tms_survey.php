<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TmsSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vehicle_id");
            $table->unsignedBigInteger("order_id");
            $table->unsignedInteger("etiquette_point");
            $table->unsignedInteger("safefy_rule_point");
            $table->unsignedInteger("work_area_cleaning_point");
            $table->unsignedInteger("service_quality_point");
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
        //
    }
}
