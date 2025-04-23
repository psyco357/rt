<?php

namespace App\Models\Auth;

use App\Models\Data\AnggotaModel;
use App\Models\Data\RoleModel;
use App\Models\Master\StatusModel;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    //
    protected $table = 'users';
    protected $fillable = [
        'idanggota',
        'name',
        'email',
        'username',
        'password',
        'role',
        'remember_token',
        'isactive',
    ];

    public function anggota()
    {
        return $this->belongsTo(AnggotaModel::class, 'idanggota', 'id');
    }

    public function roleUser()
    {
        return $this->hasOne(RoleModel::class, 'id', 'role');
    }

    public function userStatus()
    {
        return $this->hasOne(StatusModel::class, 'id', 'isactive');
    }
}
