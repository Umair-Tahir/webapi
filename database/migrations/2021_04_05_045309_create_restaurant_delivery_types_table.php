<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantDeliveryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_delivery_types', function (Blueprint $table) {
            $table->integer('delivery_type_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
            $table->primary([ 'delivery_type_id','restaurant_id']);
            $table->foreign('delivery_type_id')->references('id')->on('delivery_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_delivery_types');
    }
}
