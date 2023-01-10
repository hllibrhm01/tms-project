<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWMSCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type');
            $table->string('company_name');
            $table->unsignedBigInteger('tax_number');
            $table->string('authorized_person');
            $table->string('phone');
            $table->string('email');
            $table->string('address')->nullable();
            $table->mediumText('note')->nullable();
            $table->timestamps();
        });

        Schema::table('wms_customers', function (Blueprint $table) {
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
        Schema::dropIfExists('wms_customers');
    }
}
