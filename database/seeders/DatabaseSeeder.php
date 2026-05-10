<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        DB::table('users')->insert([

            // ADMIN
            [
                'nama'             => 'Admin Pelangi',
                'email'            => 'admin@gmail.com',
                'password'         => Hash::make('password123'),
                'no_hp'            => '08123456789',
                'alamat'           => 'Jl. Pelangi No. 1',
                'role'             => 'admin',
                'status_reseller'  => null,
                'bukti_pembayaran' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            [
                'nama'             => 'Romi Admin',
                'email'            => 'romi@gmail.com',
                'password'         => Hash::make('password123'),
                'no_hp'            => '08111111111',
                'alamat'           => 'Jl. Sudirman',
                'role'             => 'admin',
                'status_reseller'  => null,
                'bukti_pembayaran' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            // CUSTOMER
            [
                'nama'             => 'Syahdan',
                'email'            => 'syahdan@gmail.com',
                'password'         => Hash::make('password123'),
                'no_hp'            => '08222222222',
                'alamat'           => 'Jl. Arifin Ahmad',
                'role'             => 'customer',
                'status_reseller'  => null,
                'bukti_pembayaran' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            [
                'nama'             => 'Adan',
                'email'            => 'adan@gmail.com',
                'password'         => Hash::make('password123'),
                'no_hp'            => '08333333333',
                'alamat'           => 'Jl. Tuanku Tambusai',
                'role'             => 'customer',
                'status_reseller'  => null,
                'bukti_pembayaran' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            // RESELLER
            [
                'nama'             => 'Sindi Reseller',
                'email'            => 'sindi@gmail.com',
                'password'         => Hash::make('password123'),
                'no_hp'            => '08444444444',
                'alamat'           => 'Jl. Riau',
                'role'             => 'reseller',
                'status_reseller'  => 'aktif',
                'bukti_pembayaran' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],

            [
                'nama'             => 'Qwen Reseller',
                'email'            => 'qwen@gmail.com',
                'password'         => Hash::make('password123'),
                'no_hp'            => '08555555555',
                'alamat'           => 'Jl. HR Soebrantas',
                'role'             => 'reseller',
                'status_reseller'  => 'aktif',
                'bukti_pembayaran' => null,
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        DB::table('kategori')->insert([
            [
                'nama_kategori'   => 'Tas',
                'gambar_kategori' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nama_kategori'   => 'Dompet',
                'gambar_kategori' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nama_kategori'   => 'Kacamata',
                'gambar_kategori' => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PRODUK
        |--------------------------------------------------------------------------
        */

        DB::table('produk')->insert([
            [
                'id_kategori'    => 1,
                'nama_produk'    => 'Tas Wanita Elegan',
                'deskripsi'      => 'Tas elegan untuk wanita modern.',
                'harga'          => 250000,
                'harga_reseller' => 220000,
                'stok'           => 10,
                'gambar_produk'  => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_kategori'    => 2,
                'nama_produk'    => 'Dompet Kulit Premium',
                'deskripsi'      => 'Dompet kulit premium berkualitas.',
                'harga'          => 150000,
                'harga_reseller' => 130000,
                'stok'           => 15,
                'gambar_produk'  => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id_kategori'    => 3,
                'nama_produk'    => 'Kacamata Fashion',
                'deskripsi'      => 'Kacamata trendy dan stylish.',
                'harga'          => 120000,
                'harga_reseller' => 100000,
                'stok'           => 20,
                'gambar_produk'  => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PESANAN
        |--------------------------------------------------------------------------
        */

        DB::table('pesanan')->insert([
            [
                'id_user'            => 3,
                'tanggal_pesanan'   => now(),
                'total_harga'       => 250000,
                'alamat_pengiriman' => 'Jl. Arifin Ahmad',
                'layanan_kurir'     => 'JNE',
                'kode_kurir'        => 'jne',
                'ongkir'            => 18000,
                'nomor_resi'        => 'JNE001',
                'status_pesanan'    => 'diproses',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'id_user'            => 4,
                'tanggal_pesanan'   => now(),
                'total_harga'       => 150000,
                'alamat_pengiriman' => 'Jl. Tuanku Tambusai',
                'layanan_kurir'     => 'J&T',
                'kode_kurir'        => 'jnt',
                'ongkir'            => 20000,
                'nomor_resi'        => 'JNT002',
                'status_pesanan'    => 'dikirim',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'id_user'            => 5,
                'tanggal_pesanan'   => now(),
                'total_harga'       => 120000,
                'alamat_pengiriman' => 'Jl. Riau',
                'layanan_kurir'     => 'SiCepat',
                'kode_kurir'        => 'sicepat',
                'ongkir'            => 15000,
                'nomor_resi'        => 'SCP003',
                'status_pesanan'    => 'selesai',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | PENGIRIMAN
        |--------------------------------------------------------------------------
        */

        DB::table('pengiriman')->insert([
            [
                'pesanan_id' => 1,
                'kurir'      => 'JNE',
                'layanan'    => 'REG',
                'ongkir'     => 18000,
                'no_resi'    => 'JNE001',
                'status'     => 'perlu_dikirim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 2,
                'kurir'      => 'J&T',
                'layanan'    => 'EZ',
                'ongkir'     => 20000,
                'no_resi'    => 'JNT002',
                'status'     => 'dalam_perjalanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pesanan_id' => 3,
                'kurir'      => 'SiCepat',
                'layanan'    => 'BEST',
                'ongkir'     => 15000,
                'no_resi'    => 'SCP003',
                'status'     => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | RATING
        |--------------------------------------------------------------------------
        */

        DB::table('rating')->insert([
            [
                'id_user'    => 3, // Syahdan
                'id_produk'  => 1, // Tas Wanita Elegan
                'rating'     => 5,
                'komentar'   => 'Kualitas sangat bagus, sesuai deskripsi',
                'status'     => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user'    => 4, // Adan
                'id_produk'  => 2, // Dompet Kulit Premium
                'rating'     => 4,
                'komentar'   => 'Bagus tapi agak lama pengirimannya',
                'status'     => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user'    => 5, // Sindi Reseller
                'id_produk'  => 3, // Kacamata Fashion
                'rating'     => 2,
                'komentar'   => 'Warnanya beda dari foto, agak kecewa',
                'status'     => 'disembunyikan', // Status disembunyikan untuk testing
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | RETUR
        |--------------------------------------------------------------------------
        */

        DB::table('retur')->insert([
            [
                'id_user'            => 3, // Syahdan
                'id_pesanan'         => 1, 
                'id_produk'          => 1, // Tas Wanita Elegan
                'alasan_return'      => 'Tas rusak di bagian jahitan resleting',
                'bukti_return'       => null,
                'status_return'      => 'pending',
                'catatan_admin'      => null,
                'tanggal_pengajuan'  => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id_user'            => 4, // Adan
                'id_pesanan'         => 2,
                'id_produk'          => 2, // Dompet Kulit Premium
                'alasan_return'      => 'Warna dompet tidak sesuai dengan yang dipesan',
                'bukti_return'       => null,
                'status_return'      => 'diproses',
                'catatan_admin'      => 'Barang sedang dikembalikan ke gudang',
                'tanggal_pengajuan'  => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id_user'            => 5, // Sindi Reseller
                'id_pesanan'         => 3,
                'id_produk'          => 3, // Kacamata Fashion
                'alasan_return'      => 'Kacamata datang dalam keadaan pecah',
                'bukti_return'       => null,
                'status_return'      => 'selesai',
                'catatan_admin'      => 'Refund telah dikembalikan',
                'tanggal_pengajuan'  => now(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
        
    }
}