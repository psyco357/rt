<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KategoriStatusModel extends Model
{
    //
    protected $table = 'kategoristatus';
    protected $fillable = [
        'namakategori',
    ];

    public function kategoristatus()
    {
        return $this->hasMany(StatusModel::class, 'idkategoristatus', 'id');
    }
}
