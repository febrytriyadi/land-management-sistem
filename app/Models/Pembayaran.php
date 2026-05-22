<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'kontrak_id', 'cicilan_ke', 'jumlah', 'tanggal_jatuh_tempo',
        'tanggal_bayar', 'status', 'metode_pembayaran', 'keterangan', 'bukti_pembayaran'
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function kontrak(): BelongsTo
    {
        return $this->belongsTo(Kontrak::class);
    }

    public function getTerlambatAttribute(): int
    {
        if ($this->status === 'lunas') return 0;
        return max(0, now()->diffInDays($this->tanggal_jatuh_tempo, false));
    }
}
