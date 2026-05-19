<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kontrak extends Model
{
    protected $table = 'kontrak';

    protected $fillable = [
        'no_kontrak', 'tanah_id', 'penyewa_id', 'tanggal_mulai',
        'tanggal_selesai', 'biaya_sewa_total', 'jumlah_cicilan', 'status', 'keterangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function tanah(): BelongsTo
    {
        return $this->belongsTo(Tanah::class);
    }

    public function penyewa(): BelongsTo
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getBiayaPerCicilanAttribute(): float
    {
        return $this->jumlah_cicilan > 0
            ? $this->biaya_sewa_total / $this->jumlah_cicilan
            : $this->biaya_sewa_total;
    }

    public function getSisaHariAttribute(): int
    {
        return max(0, now()->diffInDays($this->tanggal_selesai, false));
    }
}
