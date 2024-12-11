<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_pembayaran');
            $table->unsignedBigInteger('id_category');
            $table->string('jumlah');
            $table->foreign('id_customer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pembayaran')->references('id')->on('pembayaran')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
