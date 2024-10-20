<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class things extends Model
{
    use HasFactory;

    protected  
    $fillable = ['thing_type','status', 'device_id',  'value_set'];
   
       public function device()
       {
           return $this->belongsTo(devices::class, 'devices_id');
       }
    
       public function things_data()
    {
        return $this->hasMany(things_data::class, );
    }

}
