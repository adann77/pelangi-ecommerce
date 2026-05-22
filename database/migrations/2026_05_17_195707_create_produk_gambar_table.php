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
        // ✅ Ganti nama tabel dari 'produk_gambars' jadi 'produk_gambar' (tanpa s)
        Schema::create('produk_gambar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk');
            $table->string('path_gambar'); // Path gambar tambahan
            $table->integer('urutan')->default(0); // Untuk mengatur urutan tampilan
            
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
        Schema::dropIfExists('produk_gambar');
    }
};