<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiTransaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_bukti_pembayaran';
    protected $fillable = ['id', 'foto', 'transaksi_id'];

    protected $keyType = 'string';

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, "transaksi_id");
    }
}
