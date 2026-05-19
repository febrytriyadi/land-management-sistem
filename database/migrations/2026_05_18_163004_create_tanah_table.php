<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tanah')->unique();
            $table->string('nama');
            $table->string('lokasi');
            $table->decimal('luas_hektar', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('tersedia'); // tersedia, disewa
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanah');
    }
};
