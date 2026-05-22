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
        Schema::table('produk_varian', function (Blueprint $table) {
            $table->string('gambar_varian')->nullable()->after('nama_varian'); // Path gambar untuk varian ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_varian', function (Blueprint $table) {
           $table->dropColumn('gambar_varian');
        });
    }
};
