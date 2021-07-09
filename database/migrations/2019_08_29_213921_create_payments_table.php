<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->double('price', 8, 2)->default(0);
            $table->string('description', 255)->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('status')->nullable();
            $table->string('method')->nullable();
            $table->string('response_code')->nullable();
            $table->string('response_message')->nullable();
            $table->string('gp_order_id')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('scheme_id')->nullable();
            $table->timestamps();
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
        Schema::drop('payments');
    }
}
