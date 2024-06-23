<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'id_user','id_meja', 'tanggal_reservasi', 'waktu_reservasi','status',
    ];

    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function meja(){
        return $this->belongsTo(Meja::class,'id_meja');
    }

    public function pesanans(){
        return $this->hasMany(Pesanan::class,'id_reservasi');
    }

    public function pembayaran(){
        return $this->hasOne(Pembayaran::class,'id_reservasi');
    }


}
