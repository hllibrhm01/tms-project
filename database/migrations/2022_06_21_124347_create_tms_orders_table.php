<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMSOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_number')->nullable();
            $table->unsignedSmallInteger('order_type');
            $table->unsignedTinyInteger('group_type');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedInteger('sms_verification_code')->nullable();
            $table->unsignedDouble('weight');
            $table->string('orderer_name');
            $table->string('orderer_phone');
            $table->string('orderer_email');
            $table->unsignedInteger('country_id')->default(1);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('district_id');
            $table->mediumText('address_description');
            $table->mediumText('note')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('attachment');
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
        Schema::dropIfExists('tms_orders');
    }
}
