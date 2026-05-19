<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tanah extends Model
{
    protected $table = 'tanah';

    protected $fillable = [
        'kode_tanah', 'nama', 'lokasi', 'luas_hektar', 'deskripsi', 'status', 'foto'
    ];

    public function kontraks(): HasMany
    {
        return $this->hasMany(Kontrak::class);
    }
}
