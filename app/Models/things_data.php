<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class things_data extends Model
{
    use HasFactory;

    protected  
    $fillable = ['thing_id','value'];
   
       public function device()
       {
           return $this->belongsTo(things::class, 'things_id');
       }
}
