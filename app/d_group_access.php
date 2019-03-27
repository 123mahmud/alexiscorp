<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_group_access extends Model
{
    protected $table = 'd_group_access';
    protected $primaryKey = 'g_access';
    protected $fillable = ['ga_access','ga_group','ga_read','ga_insert','ga_update','ga_delete'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}