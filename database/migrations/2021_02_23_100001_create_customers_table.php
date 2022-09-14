<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('email');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('postal')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->timestamps();
        });
    }
}
