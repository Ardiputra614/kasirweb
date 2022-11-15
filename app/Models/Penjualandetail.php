<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualandetail extends Model
{
  use HasFactory;
  protected $table = 'penjualan_det';
  protected $keyType = 'string';
  protected $guarded = ['no_nota_penjualan'];
  protected $primaryKey = 'no_nota_penjualan';
  public $timestamps = false;
}
