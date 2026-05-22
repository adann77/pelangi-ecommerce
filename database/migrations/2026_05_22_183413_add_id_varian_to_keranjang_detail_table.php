<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keranjang_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('id_varian')->nullable()->after('id_produk');

            $table->foreign('id_varian')
                  ->references('id')
                  ->on('produk_varian')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('keranjang_detail', function (Blueprint $table) {
            $table->dropForeign(['id_varian']);
            $table->dropColumn('id_varian');
        });
    }
};