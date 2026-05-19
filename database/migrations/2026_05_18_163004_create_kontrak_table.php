<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontrak', function (Blueprint $table) {
            $table->id();
            $table->string('no_kontrak')->unique();
            $table->foreignId('tanah_id')->constrained('tanah')->onDelete('cascade');
            $table->foreignId('penyewa_id')->constrained('penyewa')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('biaya_sewa_total', 15, 2);
            $table->integer('jumlah_cicilan')->default(1);
            $table->string('status')->default('aktif'); // aktif, selesai, dibatalkan
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontrak');
    }
};
