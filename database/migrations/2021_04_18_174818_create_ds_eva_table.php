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
            $table->bigIncrements('id');
            $table->integer('order_id')->unsigned();
            $table->integer('service_type_id')->unsigned()->default(1);
            $table->integer('tip_token_charge')->unsigned()->default(0);
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
