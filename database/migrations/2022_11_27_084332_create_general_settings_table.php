<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('copyright')->nullable();
            $table->unsignedDouble('daily_meal_price');
            $table->mediumText('code_mandatory_status')->nullable();
            $table->mediumText('note_mandatory_status')->nullable();
            $table->mediumText('image_mandatory_status')->nullable();
            $table->mediumText('dealer_notify_mandatory_status')->nullable();
            $table->mediumText('planner_notify_mandatory_status')->nullable();
            $table->mediumText('orderer_notify_mandatory_status')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
