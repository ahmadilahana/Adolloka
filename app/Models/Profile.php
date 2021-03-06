<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "tb_user";
    protected $fillable = ['nama', 'profile_id', 'gender', 'tgl_lahir', 'akun_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'akun_id');
    }
    public function foto()
    {
        return $this->belongsto(FotoProfile::class, 'profile_id');
    }
}
