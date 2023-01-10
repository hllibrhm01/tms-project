<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("district_id");
            $table->string('name' , 100);
            $table->timestamps();
        });

        Schema::table('tax_departments', function (Blueprint $table) 
        {
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
        Schema::dropIfExists('tax_departments');
    }
}
