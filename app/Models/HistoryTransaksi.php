<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransaksi extends Model
{
    use HasFactory;

    protected $table = "tb_history_transaksi";
    protected $fillable = ['tgl_transaksi', 'barang_id', 'toko_id', 'keterangan', 'jumlah', 'total_harga', 'akun_id', 'alamat_id', 'bukti_pembayaran', 'kode_resi'];
}
