<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';

    public function pecah()
    {
        return $this->belongsTo(Pecah::class, 'kd_produk');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nama_produk', 'LIKE', "%{$search}%");
    }
}
