<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TmsPreorder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_preorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("tms_customer_id");
            $table->unsignedSmallInteger('order_type');
            $table->unsignedInteger('weight');
            $table->string('orderer_name');
            $table->string('orderer_phone');
            $table->string('orderer_email');
            $table->unsignedInteger('country_id')->default(1);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('district_id');
            $table->mediumText('address_description');
            $table->mediumText('note')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
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
        //
    }
}
