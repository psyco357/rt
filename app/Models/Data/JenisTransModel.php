<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class JenisTransModel extends Model
{
    //
    protected $table = 'jenistransaksi';
    protected $fillanle = [
        'namajenis',
        'status',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiModel::class, 'jenistransaksi', 'id');
    }
}
