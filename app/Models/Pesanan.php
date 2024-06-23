<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
  protected $primaryKey = 'id_pesanan';
  protected $fillable =[
    'id_reservasi', 'id_menu','jumlah_pesanan',
  ];

  public function reservasi(){
    return $this->belongsTo(Reservasi::class,'id_reservasi');
  }

  public function menu(){
    return $this->belongsTo(Menu::class,'id_menu');
  }
}
