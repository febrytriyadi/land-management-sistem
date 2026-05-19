<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyewa extends Model
{
    protected $table = 'penyewa';

    protected $fillable = [
        'nama', 'email', 'no_hp', 'alamat', 'perusahaan'
    ];

    public function kontraks(): HasMany
    {
        return $this->hasMany(Kontrak::class);
    }
}
