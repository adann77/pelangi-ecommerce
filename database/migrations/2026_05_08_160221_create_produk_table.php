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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_produk', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->decimal('harga_reseller', 12, 2)->nullable();
            $table->integer('stok')->default(0);
            $table->string('gambar_produk', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};