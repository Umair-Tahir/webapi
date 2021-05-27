<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsTiktakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_tiktak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->string('distance')->nullable();
            $table->string('job_id')->nullable();
            $table->string('delivery_job_id')->nullable();
            $table->string('job_token')->nullable();
            $table->double('total', 5, 2)->nullable()->default(0);
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
        Schema::dropIfExists('ds_tiktak');
    }
}
