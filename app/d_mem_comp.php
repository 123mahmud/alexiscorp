<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mem_comp extends Model
{
    protected $table = 'd_mem_comp';
    protected $primaryKey = 'mc_mem';
    protected $fillable = ['mc_mem',
    					   'mc_comp',
    					   'mc_lvl',
    					   'mc_active',
    					   'mc_insert',
    					   'mc_update'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}