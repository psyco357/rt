<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class AnggotaModel extends Model
{
    //
    protected $table = 'anggota';
    protected $fillable = [
        'id',
        'ktp',
        'nama',
        'alamat',
        'no_telepon',
        'tanggal_masuk',
        'created_at',
        'updated_at'
    ];
    // protected $primaryKey = 'id';
}
