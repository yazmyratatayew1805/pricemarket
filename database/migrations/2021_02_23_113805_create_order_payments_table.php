<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table): void {
            $table->uuid('uuid')->unique();

            $table->uuid('order_uuid');
            $table->foreign('order_uuid')->references('uuid')->on('orders')->onDelete('cascade');

            $table->string('state');

            $table->integer('total_item_price_including_vat');

            $table->dateTime('failed_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }
}
