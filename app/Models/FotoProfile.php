<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoProfile extends Model
{
    use HasFactory;
    protected $table = "tb_ft_profile";
    protected $fillable = ['id', 'foto'];
    public $timestamps = false;
    // protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function foto()
    {
        return $this->hasOne(Profile::class, "profile_id");
    }
}
