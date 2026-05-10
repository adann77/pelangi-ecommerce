<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retur', function (Blueprint $table) {
            $table->id('id_return');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_user');
            $table->text('alasan_return');
            $table->string('bukti_return', 255)->nullable();
            $table->string('status_return', 20)->default('pending'); // pending / diproses / selesai / ditolak
            $table->text('catatan_admin')->nullable();
            $table->datetime('tanggal_pengajuan')->useCurrent();
            $table->timestamps();

            $table->foreign('id_pesanan')
                  ->references('id_pesanan')
                  ->on('pesanan')
                  ->onDelete('cascade');

            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onDelete('cascade');

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retur');
    }
};