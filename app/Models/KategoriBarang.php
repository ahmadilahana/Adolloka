<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = "tb_kat_barang";


    public function barang()
    {
        return $this->hasMany(Barang::class, "kategori_id");
    }
}
