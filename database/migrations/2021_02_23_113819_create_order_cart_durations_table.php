<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCartDurationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('cart_durations', function (Blueprint $table): void {
            $table->uuid('uuid')->unique();
            $table->uuid('cart_uuid');
            $table->dateTime('created_at');
            $table->dateTime('checked_out_at')->nullable();
            $table->integer('duration_in_minutes')->nullable();
        });
    }
}
