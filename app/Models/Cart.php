<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "tb_cart";
    protected $fillable = ['akun_id', 'barang_id', 'jumlah'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, "barang_id");
    }
}
