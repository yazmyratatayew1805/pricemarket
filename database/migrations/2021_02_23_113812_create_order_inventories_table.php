<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInventoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table): void {
            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedInteger('amount');

            $table->timestamps();
        });
    }
}
