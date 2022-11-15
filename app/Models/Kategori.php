<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
  use HasFactory;

  protected $table = 'kategori';
  protected $primaryKey = '';
  protected $guarded = [''];
  public $timestamps = false;

  public function pecah()
  {
    return $this->hasOne(Pecah::class, 'kategori');
  }
}
