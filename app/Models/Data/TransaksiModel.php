<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    //
    protected $table = 'transaksi';
    protected $fillable = [
        'idanggota',
        'jenistrans',
        'jumlah',
        'idgambar',
        'keterangan',
        'author',
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaModel::class, 'idanggota', 'id');
    }
    public function jenisTransaksi()
    {
        return $this->belongsTo(JenisTransModel::class, 'jenistrans', 'id');
    }
    public function gambar()
    {
        return $this->belongsTo(GambarModel::class, 'idgambar', 'id');
    }

    public function author()
    {
        return $this->belongsTo(AnggotaModel::class, 'author', 'id');
    }
}
