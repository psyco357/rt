<?php

namespace App\Models\Master;

use App\Models\Auth\UserModel;
use App\Models\Data\JenisTransModel;
use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    //
    protected $table = 'status';
    protected $fillable = [
        'idkategoristatus',
        'namastatus',
    ];
    public function kategoristatus()
    {
        return $this->belongsTo(KategoriStatusModel::class, 'idkategoristatus', 'id');
    }
    public function userStaatus()
    {
        return $this->hasMany(UserModel::class, 'isactive', 'id');
    }
    public function statusTrans()
    {
        return $this->hasMany(JenisTransModel::class, 'status', 'id');
    }
}
