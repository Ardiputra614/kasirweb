<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualanfix extends Model
{
  use HasFactory;
  protected $table = 'penjualan_fix';
  protected $primaryKey = 'no';
  public $timestamps = false;
  protected $keyType = 'string';
  protected $guarded = ['no'];
}
