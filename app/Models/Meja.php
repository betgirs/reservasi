<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $primaryKey = 'id_meja';
    
    protected $fillable =[
        'jumlah_orang',
    ];

    public function reservasis(){
        return $this->hasMany(Reservasi::class,'id_meja');
    }
}
