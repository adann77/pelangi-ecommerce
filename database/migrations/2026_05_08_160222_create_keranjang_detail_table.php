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
       Schema::create('keranjang_detail', function (Blueprint $table) {
            $table->id('id_keranjang_detail');
            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('id_produk');
            $table->integer('kuantitas')->default(1);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
 
            $table->foreign('id_keranjang')
                  ->references('id_keranjang')
                  ->on('keranjang')
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
        Schema::dropIfExists('keranjang_detail');
    }
};
