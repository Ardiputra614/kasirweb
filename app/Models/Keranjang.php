<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
  use HasFactory;
  protected $table = 'penjualan_b_copy';
  protected $guarded = ['no'];
  protected $keyType = 'string';
  // protected $with = ['barang'];
  public $timestamps = false;

  public function pecah()
  {
    return $this->belongsTo(Pecah::class, 'kd_produk');
  }
}
