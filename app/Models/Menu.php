<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'nama_menu', 'harga',
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_menu');
    }

    public function getFormattedHargaAttribute()
    {
        return number_format($this->attributes['harga'], 2, ',', '.');
    }
}