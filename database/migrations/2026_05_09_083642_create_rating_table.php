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
        // Schema::create('rating', function (Blueprint $table) {
        //     $table->increments('id_rating');

        //     // Foreign key ke users
        //     $table->unsignedBigInteger('id_user');
        //     $table->foreign('id_user')
        //           ->references('id_user')
        //           ->on('users')
        //           ->onDelete('cascade');

        //     // Foreign key ke produk
        //     $table->unsignedBigInteger('id_produk');
        //     $table->foreign('id_produk')
        //           ->references('id_produk')
        //           ->on('produk')
        //           ->onDelete('cascade');

        //     // Rating
        //     $table->unsignedTinyInteger('rating')
        //           ->comment('Rating bintang 1-5');

        //     // Komentar
        //     $table->text('komentar')->nullable();

        //     // Unique
        //     $table->unique(
        //         ['id_user', 'id_produk'],
        //         'unique_user_produk_rating'
        //     );

        //     $table->timestamps();
        // });
        // D:\Projek Akhir\pelangi-ecommerce\database\migrations\2026_05_09_083642_create_rating_table.php

        Schema::create('rating', function (Blueprint $table) {
            $table->increments('id_rating');

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');

            $table->unsignedTinyInteger('rating')->comment('Rating bintang 1-5');
            $table->text('komentar')->nullable();
            
            // TAMBAHKAN INI
            $table->enum('status', ['aktif', 'disembunyikan'])->default('aktif');

            $table->unique(['id_user', 'id_produk'], 'unique_user_produk_rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};