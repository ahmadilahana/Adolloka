<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $table = "tb_chart";
    protected $fillable = ['id_akun', 'id_barang', 'jumlah'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, "id_barang");
    }
}
