<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('expected_delivery_time')->nullable();
            $table->double('vendor_shared_price', 5, 2)->nullable()->default(0);
            $table->double('eezly_shared_price', 5, 2)->nullable()->default(0);
            $table->double('grand_total', 5, 2)->nullable()->default(0);
            $table->boolean('is_french')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
