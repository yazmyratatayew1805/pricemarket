<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->uuid('uuid')->unique();
            $table->string('order_number')->unique();

            $table->uuid('cart_uuid');
            $table->foreign('cart_uuid')->references('uuid')->on('carts');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->string('state');

            $table->integer('total_item_price_excluding_vat')->default(0);
            $table->integer('total_item_price_including_vat')->default(0);

            $table->integer('shipping_costs_vat_percentage')->nullable();
            $table->integer('shipping_costs_excluding_vat')->nullable();
            $table->integer('shipping_costs_including_vat')->nullable();

            $table->string('coupon_code')->nullable();
            $table->integer('coupon_reduction')->nullable();

            $table->string('invoice_path')->nullable();

            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }
}
