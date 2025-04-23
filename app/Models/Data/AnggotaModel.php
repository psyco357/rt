<?php

namespace App\Models\Data;

use App\Models\Auth\UserModel;
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
    public function transaksi()
    {
        return $this->hasMany(TransaksiModel::class, 'idanggota', 'id');
    }
    public function author()
    {
        return $this->hasMany(AnggotaModel::class, 'author', 'id');
    }
    public function user()
    {
        return $this->hasOne(UserModel::class, 'idanggota', 'id');
    }
}
