<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        DB::table('users')->upsert([
            'name' => 'Admin Inhutani',
            'email' => 'admin@inhutani.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'email');

        // Create sample petugas
        DB::table('users')->upsert([
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@inhutani.id',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'created_at' => now(),
            'updated_at' => now(),
        ], 'email');

        // Tanah
        DB::table('tanah')->insert([
            ['kode_tanah' => 'TH-001', 'nama' => 'Tanah HGU Sukamaju', 'lokasi' => 'Sukamaju, Kaltim', 'luas_hektar' => 150.50, 'deskripsi' => 'Kawasan hutan produksi, cocok untuk perkebunan kelapa sawit', 'status' => 'disewa', 'created_at' => now(), 'updated_at' => now()],
            ['kode_tanah' => 'TH-002', 'nama' => 'Tanah HGU Sumberrejo', 'lokasi' => 'Sumberrejo, Jatim', 'luas_hektar' => 85.00, 'deskripsi' => 'Lahan pertanian subur, irigasi baik', 'status' => 'disewa', 'created_at' => now(), 'updated_at' => now()],
            ['kode_tanah' => 'TH-003', 'nama' => 'Tanah HGU Tanjungpinang', 'lokasi' => 'Tanjungpinang, Kepri', 'luas_hektar' => 220.75, 'deskripsi' => 'Kawasan industri, dekat pelabuhan', 'status' => 'tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['kode_tanah' => 'TH-004', 'nama' => 'Tanah HGU Cilacap', 'lokasi' => 'Cilacap, Jateng', 'luas_hektar' => 45.25, 'deskripsi' => 'Lahan sawit siap tanam', 'status' => 'tersedia', 'created_at' => now(), 'updated_at' => now()],
            ['kode_tanah' => 'TH-005', 'nama' => 'Tanah HGU Banjarmasin', 'lokasi' => 'Banjarmasin, Kalsel', 'luas_hektar' => 310.00, 'deskripsi' => 'Kawasan HTI (Hutan Tanaman Industri)', 'status' => 'disewa', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Penyewa
        DB::table('penyewa')->insert([
            ['nama' => 'PT Sawit Makmur Sentosa', 'email' => 'finance@sawitmakmur.co.id', 'no_hp' => '081234567890', 'alamat' => 'Jakarta Selatan', 'perusahaan' => 'PT Sawit Makmur Sentosa', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'CV Agro Tani Lestari', 'email' => 'info@agrotani.com', 'no_hp' => '087654321098', 'alamat' => 'Surabaya, Jatim', 'perusahaan' => 'CV Agro Tani Lestari', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'PT Hutan Hijau Abadi', 'email' => 'admin@hutanhijau.co.id', 'no_hp' => '085712345678', 'alamat' => 'Banjarmasin, Kalsel', 'perusahaan' => 'PT Hutan Hijau Abadi', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Kontrak
        DB::table('kontrak')->insert([
            ['no_kontrak' => 'KTR-20260101-001', 'tanah_id' => 1, 'penyewa_id' => 1, 'tanggal_mulai' => '2026-01-01', 'tanggal_selesai' => '2028-12-31', 'biaya_sewa_total' => 1800000000, 'jumlah_cicilan' => 36, 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['no_kontrak' => 'KTR-20260301-002', 'tanah_id' => 2, 'penyewa_id' => 2, 'tanggal_mulai' => '2026-03-01', 'tanggal_selesai' => '2027-02-28', 'biaya_sewa_total' => 510000000, 'jumlah_cicilan' => 12, 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['no_kontrak' => 'KTR-20250801-003', 'tanah_id' => 5, 'penyewa_id' => 3, 'tanggal_mulai' => '2025-08-01', 'tanggal_selesai' => '2030-07-31', 'biaya_sewa_total' => 3720000000, 'jumlah_cicilan' => 60, 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Pembayaran
        for ($i = 1; $i <= 5; $i++) {
            DB::table('pembayaran')->insert([
                'kontrak_id' => 1, 'cicilan_ke' => $i, 'jumlah' => 50000000,
                'tanggal_jatuh_tempo' => date('Y-m-d', strtotime("2026-01-01 +{$i} month")),
                'tanggal_bayar' => $i <= 4 ? date('Y-m-d', strtotime("2026-01-01 +{$i} month")) : null,
                'status' => $i <= 4 ? 'lunas' : 'belum_dibayar',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        for ($i = 1; $i <= 3; $i++) {
            DB::table('pembayaran')->insert([
                'kontrak_id' => 2, 'cicilan_ke' => $i, 'jumlah' => 42500000,
                'tanggal_jatuh_tempo' => date('Y-m-d', strtotime("2026-03-01 +{$i} month")),
                'tanggal_bayar' => $i <= 2 ? date('Y-m-d', strtotime("2026-03-05 +{$i} month")) : null,
                'status' => $i <= 2 ? 'lunas' : 'terlambat',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
        for ($i = 1; $i <= 4; $i++) {
            DB::table('pembayaran')->insert([
                'kontrak_id' => 3, 'cicilan_ke' => $i, 'jumlah' => 62000000,
                'tanggal_jatuh_tempo' => date('Y-m-d', strtotime("2025-08-01 +{$i} month")),
                'tanggal_bayar' => $i <= 3 ? date('Y-m-d', strtotime("2025-08-05 +{$i} month")) : null,
                'status' => $i <= 3 ? 'lunas' : 'belum_dibayar',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        echo "✅ Seeder selesai!\n";
    }
}
