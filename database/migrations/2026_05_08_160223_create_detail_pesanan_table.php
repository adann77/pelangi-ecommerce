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
        // Tabel Detail Pesanan (order items)
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_produk');
            $table->decimal('harga_satuan', 12, 2);
            $table->integer('kuantitas')->default(1);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
 
            $table->foreign('id_pesanan')
                  ->references('id_pesanan')
                  ->on('pesanan')
                  ->onDelete('cascade');
 
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
