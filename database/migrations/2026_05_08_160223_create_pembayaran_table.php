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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan');
            $table->string('transaction_id', 100)->nullable();
            $table->string('metode_pembayaran', 50)->nullable();
            $table->string('status_pembayaran', 20)->default('pending'); // pending / success
            $table->datetime('tanggal_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('id_pesanan')
                  ->references('id_pesanan')
                  ->on('pesanan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};