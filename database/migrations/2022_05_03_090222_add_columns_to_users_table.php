<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('user_id')->nullable();
            $table->dropColumn('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->boolean('allowed_to_bid')->default(0);
            $table->boolean('business_member')->default(0);
            $table->boolean('no_fees')->default(0);
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postcode')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift_bic')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('transferwise_email')->nullable();
            $table->string('transferwise_name')->nullable();
            $table->string('transferwise_iban')->nullable();
            $table->string('payment_method')->nullable();
            $table->json('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('contact_number');
            $table->dropColumn('mobile_number');
            $table->dropColumn('allowed_to_bid');
            $table->dropColumn('business_member');
            $table->dropColumn('no_fees');
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('postcode');
            $table->dropColumn('bank_account');
            $table->dropColumn('iban');
            $table->dropColumn('swift_bic');
            $table->dropColumn('billing_name');
            $table->dropColumn('paypal_email');
            $table->dropColumn('transferwise_email');
            $table->dropColumn('transferwise_name');
            $table->dropColumn('transferwise_iban');
            $table->dropColumn('payment_method');
            $table->dropColumn('note');
        });
    }
}
