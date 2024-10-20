<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suhu extends Model
{
    use HasFactory;

    protected $table = 'suhus';

    protected $fillable = ['device_id', 'suhu', 'created_at'];
}
