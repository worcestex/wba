<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->uuid('order_id');
            $table->string('payment_method');
            $table->timestamp('purchase_date');
            $table->string('shipping_service');
            $table->float('starting_price');
            $table->bigInteger('buyer_id');
            $table->bigInteger('order_status_id');
            $table->integer('number_of_boxes');
            $table->json('note')->nullable();
            $table->string('billing_country');
            $table->float('cost');
            $table->boolean('is_shipped');
            $table->string('shipment_details');
            $table->boolean('is_confirmation_sent');
            $table->float('delivery_cost');
            $table->bigInteger('vat_percentage_id');
            $table->float('vat_amount');
            $table->float('total_amount');
            $table->boolean('is_payment_confirmed');
            $table->timestamp('payment_date')->nullable();
            $table->ipAddress('client_ip');
            $table->integer('number_of_items')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
