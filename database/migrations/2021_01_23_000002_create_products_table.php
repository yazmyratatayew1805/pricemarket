<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->integer('item_price');
            $table->integer('vat_percentage');
            $table->boolean('manages_inventory')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->timestamps();
        });
    }
}
