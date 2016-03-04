<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->integer('vat_rate');
            $table->string('stripe_billing_id');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_city');
            $table->string('customer_country');
            $table->string('customer_zip');
            $table->string('customer_email');
            $table->string('customer_phone_number');
            $table->string('billys_contact_id');
            $table->string('billys_invoice_id');
            $table->boolean('sendSms')->default(0);

            $table->boolean('confirmed')->default(0);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('orders');
    }
}
