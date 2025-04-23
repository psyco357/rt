<?php

namespace App\Models\Data;

use App\Models\Master\StatusModel;
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

    public function statusTrans()
    {
        return $this->hasOne(StatusModel::class, 'id', 'status');
    }
}
