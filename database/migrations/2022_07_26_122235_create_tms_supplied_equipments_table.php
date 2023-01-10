<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmsSuppliedEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_supplied_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
        });
        
        Schema::table('tms_supplied_equipments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tms_supplied_equipments');
    }
}
