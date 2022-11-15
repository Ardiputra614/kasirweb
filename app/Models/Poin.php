<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    use HasFactory;
    protected $table = 'poin';
    protected $dataType = 'string';
    protected $primaryKey = 'kd_point';
    protected $guarded = ['kd_point'];
}
