<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pesanan_id')->unique();

            $table->foreign('pesanan_id')
                ->references('id_pesanan')    // ← matches pesanan's actual PK
                ->on('pesanan')
                ->cascadeOnDelete();

            $table->string('kurir');
            $table->string('layanan')->nullable();
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->string('no_resi')->nullable();

            $table->enum('status', [
                'perlu_dikirim',
                'dalam_perjalanan',
                'selesai',
            ])->default('perlu_dikirim');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};