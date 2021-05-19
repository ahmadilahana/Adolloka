<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatUser extends Model
{
    use HasFactory;
    protected $table = "tb_almt_user";
    protected $fillable = ['alamat', 'jns_alamat', 'status', 'user_id', 'penerima', 'no_hp'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Profile::class, 'user_id');
    }
}
