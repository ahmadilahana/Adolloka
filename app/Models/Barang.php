<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = "tb_barang";
    protected $fillable = ['nama', 'jumlah', 'harga', 'deskripsi', 'kategori_id', 'toko_id'];
    public $timestamps = false;

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function chart()
    {
        return $this->hasMany(Chart::class, "id_barang");
    }
}
