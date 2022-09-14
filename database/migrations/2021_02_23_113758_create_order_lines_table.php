<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLinesTable extends Migration
{
    public function up(): void
    {
        Schema::create('order_lines', function (Blueprint $table): void {
            $table->uuid('uuid')->unique();

            $table->uuid('order_uuid');
            $table->foreign('order_uuid')->references('uuid')->on('orders')->onDelete('cascade');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('description');

            $table->integer('amount');
            $table->integer('price_per_item_excluding_vat');
            $table->integer('price_per_item_including_vat');
            $table->integer('vat_percentage');
            $table->integer('vat_price');
            $table->integer('total_item_price_excluding_vat');
            $table->integer('total_item_price_including_vat');

            $table->timestamps();
        });
    }
}
