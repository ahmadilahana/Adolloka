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
        return $this->hasMany(Chart::class, "barang_id");
    }

    public function foto()
    {
        return $this->hasMany(FotoBarang::class, "barang_id");
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, "barang_id");
    }

    public function kategori()
    {
        return $this->belongsTo(Barang::class, "kategori_id");
    }
}
