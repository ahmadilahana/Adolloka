<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = "tb_transaksi";
    protected $fillable = ['tgl_transaksi', 'barang_id', 'toko_id', 'keterangan', 'jumlah', 'total_harga', 'akun_id', 'alamat_id', 'status', 'kode_resi'];
    public $timestamps = false;

    public function bukti()
    {
        return $this->hasOne(BuktiTransaksi::class, "transaksi_id");
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
