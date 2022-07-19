<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('value_1');
            $table->string('value_2');
            $table->string('min_order_value');
            $table->boolean('is_first_order');
            $table->boolean('is_disabled');
            $table->boolean('applies_to_all_stock');
            $table->string('restricted_brand'); // might need refactor to big  int if we end up with a brands table
            $table->string('restricted_category'); // might need refactor to big  int if we end up with a categories table
            $table->bigInteger('restricted_product_id');
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
        Schema::dropIfExists('discounts');
    }
}
