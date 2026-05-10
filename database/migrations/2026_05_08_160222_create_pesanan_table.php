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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_user');
            $table->datetime('tanggal_pesanan')->useCurrent();
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->text('alamat_pengiriman');
            $table->string('layanan_kurir', 50)->nullable();
            $table->string('kode_kurir', 20)->nullable();
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->string('nomor_resi', 50)->nullable();
            $table->string('status_pesanan', 20)->default('pending'); // pending/diproses/dikirim/selesai
            $table->timestamps();
 
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
