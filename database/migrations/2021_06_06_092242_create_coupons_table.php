<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            // The voucher code
            $table->string( 'code' );
            // The human readable voucher code name
            $table->string( 'name' );
            // The description of the voucher - Not necessary
            $table->text( 'description' )->nullable( );
            // The number of uses currently
            $table->integer( 'uses' )->unsigned( )->nullable( )->default(0);
            // The max uses this voucher has
            $table->integer( 'max_uses' )->unsigned()->nullable( );
            // How many times a user can use this voucher.
            $table->integer( 'max_uses_user' )->unsigned( )->nullable( );
            // Whether or not the voucher is a percentage or a fixed price.
            $table->tinyInteger( 'type' )->unsigned( );
            // The amount to discount by if is fixed price  in this example.
            $table->double( 'discount_amount',5,2 )->nullable( );
//            // The percentage to discount by if is fixed price  in this example.
//            $table->integer( 'percent_off' )->unsigned( )->nullable( );
//            UID of the creator
            $table->integer('user_id')->unsigned();
            // If voucher is active
            $table->boolean('active')->default(1); // added
            // When the voucher begins
            $table->string( 'starts_at' );
            // When the voucher ends
            $table->string( 'expires_at' );
            $table->timestamps( );
            // We like to horde data.
            $table->softDeletes( );


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
