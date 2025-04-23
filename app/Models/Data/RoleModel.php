<?php

namespace App\Models\Data;

use App\Models\Auth\UserModel;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    //
    protected $table = 'role';
    protected $fillable = [
        'name',
    ];

    public function roleUser()
    {
        return $this->hasMany(UserModel::class, 'role', 'id');
    }
}
