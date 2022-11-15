<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pecah extends Model
{
    protected $table = 'pecah_stok';
    protected $primaryKey = 'barcode';
    protected $keyType = 'string';
    protected $guarded = [''];
    protected $with = 'kategori';

    // public function scopeFilter($query, array $filters)
    // {
    //   if (isset($filters['search']) ? $filters['search'] : false) {
    //     return $query->where('nama_produk', 'LIKE', '%' . $filters['search'] . '%');
    //   }
    // }
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_produk', 'LIKE', "%{$search}%");
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'nama_kategori');
    }

    public function keranjang()
    {
        return $this->hasOne(Keranjang::class, 'kd_produk');
    }

    public function produk()
    {
        return $this->hasOne(Produk::class, 'kd_produk');
    }
}
