<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_kendaraan extends Model
{
    protected $table = 'm_kendaraan';
    protected $primaryKey = 'k_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
