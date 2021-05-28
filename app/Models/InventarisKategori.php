<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarisKategori extends Model
{
    protected $table = 'inventaris_kategori';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }
}
