<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';

    protected $fillable = [
        'nama', 'type', 'jumlah', 'kondisi', 'keterangan'
    ];

    public function scopeBarang()
    {
        return $this->where('type','barang');
    }

    public function scopeRuangan()
    {
        return $this->where('type','ruangan');
    }

    public function inventaris_kategori()
    {
        return $this->hasMany(InventarisKategori::class,'id_inventaris','id');
    }
}
