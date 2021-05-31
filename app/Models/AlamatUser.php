<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatUser extends Model
{
    use HasFactory;
    protected $table = "tb_almt_user";
    protected $fillable = ['alamat', 'desa', 'kecamatan', 'kota', 'provinsi', 'kd_pos', 'jns_alamat', 'status', 'akun_id', 'penerima', 'no_hp'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
