<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMSCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tms_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_type');
            $table->unsignedBigInteger('work_type');
            $table->string('company_name');
            $table->unsignedTinyInteger('billing_period');
            $table->unsignedTinyInteger('payment_type');
            $table->string('iban');
            $table->unsignedInteger('tax_department_city_id');
            $table->unsignedInteger('tax_department_district_id');
            $table->unsignedInteger('tax_department_id');
            $table->unsignedBigInteger('tax_number');
            $table->mediumText('note')->nullable();
            $table->unsignedDouble('progress_payment_rate');
            $table->unsignedTinyInteger('progress_payment_type');
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
        Schema::dropIfExists('tms_customers');
    }
}
