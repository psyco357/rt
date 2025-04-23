<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KhasModel extends Model
{
    //
    protected $table = 'khas';
    protected $fillable = [
        'tahun',
        'khas',
    ];
}
