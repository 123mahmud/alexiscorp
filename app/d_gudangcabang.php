<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_gudangcabang extends Model
{
    protected $table = 'd_gudangcabang';
    protected $primaryKey = 'gc_id';
    protected $fillable = [ 'gc_id', 
                            'gc_gudang', 
                            'gc_comp'];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'cg_insert';
    const UPDATED_AT = 'cg_update';
}
