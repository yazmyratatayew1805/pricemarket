<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table): void {
            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->string('status');
            $table->string('lock_status');

            $table->integer('total_item_price_excluding_vat')->default(0);
            $table->integer('total_item_price_including_vat')->default(0);

            $table->integer('shipping_costs_vat_percentage')->nullable();
            $table->integer('shipping_costs_excluding_vat')->nullable();
            $table->integer('shipping_costs_including_vat')->nullable();

            $table->string('coupon_code')->nullable();
            $table->integer('coupon_reduction')->nullable();

            $table->timestamps();
        });

        Schema::table('customers', function (Blueprint $table): void {
            $table->uuid('active_cart_uuid')->nullable()->after('id');
            $table->foreign('active_cart_uuid')->references('uuid')->on('carts')->onDelete('set null');
        });
    }
}
