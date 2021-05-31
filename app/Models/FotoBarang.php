<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoBarang extends Model
{
    use HasFactory;

    protected $table = 'tb_ft_barang';
    protected $fillable = ['id', 'foto', 'barang_id'];

    protected $keyType = 'string';
    public $timestamps = false;

}
