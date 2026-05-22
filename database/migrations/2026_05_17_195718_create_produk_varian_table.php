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
        // ✅ Ganti nama tabel dari 'produk_varians' jadi 'produk_varian' (tanpa s)
        Schema::create('produk_varian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk');
            $table->string('nama_varian', 50); // Contoh: "Merah", "Hijau", "Size M"
            $table->integer('stok_varian')->default(0); // Stok per varian
            
            // Foreign key ke tabel produk
            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_varian');
    }
};