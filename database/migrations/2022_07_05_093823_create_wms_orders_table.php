<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('wms_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedInteger('weight');
            $table->string('phone');
            $table->unsignedInteger('country')->default(1);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('district_id');
            $table->mediumText('product_info');
            $table->mediumText('address_description');
            $table->mediumText('note')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::table('wms_orders', function (Blueprint $table) {
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
        Schema::dropIfExists('wms_orders');
    }
}
