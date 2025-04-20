<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class GambarModel extends Model
{
    //
    protected $table = 'gambar';
    protected $fillable = [
        'id',
        'namagambar',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiModel::class, 'idgambar', 'id');
    }
}
