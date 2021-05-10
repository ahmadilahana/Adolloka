<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = "tb_toko";
    protected $fillable = ['nama_toko', 'alamat', 'akun_id'];
    public $timestamps = false;

    
    public function akun()
    {
        return $this->belongsTo(User::class, 'akun_id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'toko_id');
    }
}
