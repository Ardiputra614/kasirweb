<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'histori_opname';
    protected $primaryKey = 'kd_opname';
    protected $guarded = ['kd_opname'];
    public $timestamps = false;
}
