<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsEvaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_eva', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->string('distance')->nullable();
            $table->double('total_charges_plus_tax', 5, 2)->nullable()->default(0);
            $table->double('delivery_tax', 5, 3)->nullable()->default(0);
            $table->integer('service_type_id')->unsigned()->default(1);
            $table->double('tip_token_charge')->unsigned()->default(0);
            $table->string('tracking_id')->nullable();
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
        Schema::dropIfExists('ds_eva');
    }
}
