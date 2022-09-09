<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->nullable(); // item serial number
            $table->boolean('featured')->default(false);
            $table->foreignId('auction_id')->nullable();
            $table->integer('winning_bid')->nullable();
            $table->foreignId('bid_increment_id')->nullable();
            $table->string('status')->nullable();
            $table->float('item_price_excl_vat')->nullable();
            $table->float('vat_rate')->nullable();
            $table->boolean('is_vat_deductable')->default(false);
            $table->boolean('is_published')->default(false);
            $table->float('max_bid')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('description_2')->nullable();
            $table->float('buyer_commission')->nullable();
            $table->float('seller_commission')->nullable();
            $table->float('shipping_weight', 6, 2)->nullable();
            $table->integer('size')->nullable();
            $table->string('bottler')->nullable();
            $table->string('whisky')->nullable();
            $table->string('distillery_status')->nullable();
            $table->string('fill_level')->nullable();
            $table->string('cask_finish')->nullable();
            $table->string('cask_type')->nullable();
            $table->float('strength', 4, 1)->nullable();
            $table->string('bottle_grouping')->nullable();
            $table->string('distillery')->nullable();
            $table->string('type')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('brand')->nullable();
            $table->integer('age')->nullable();
            $table->integer('number_of_bottles')->nullable();
            $table->string('batch_no')->nullable();
            $table->string('bottle_no')->nullable();
            $table->string('cask_no')->nullable();
            $table->float('decanter_weight', 6, 2)->nullable();
            $table->json('please_note')->nullable();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->boolean('ignore_late_payment')->default(false);
            $table->unsignedBigInteger('seller_id');
            $table->float('reserve_price')->nullable();
            $table->float('min_price')->nullable();
            $table->float('abv')->nullable();
            $table->integer('volume_cl')->nullable();
            $table->float('starting_price')->nullable();
            $table->float('buy_it_now_price')->nullable();
            $table->string('epos_code')->nullable();
            $table->unsignedBigInteger('lot_pickup_method_id')->nullable();
            $table->unsignedBigInteger('lot_collection_point_id')->nullable();
            $table->json('images')->nullable();
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
        Schema::dropIfExists('lots');
    }
}
