<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table): void {
            $table->id();

            $table->string('code');
            $table->integer('reduction');

            $table->timestamps();
        });
    }
}
