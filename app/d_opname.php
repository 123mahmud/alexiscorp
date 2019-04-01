<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_opname extends Model
{
  protected $table = 'd_opname';
  protected $primaryKey = 'o_id';
  protected $fillable = [ 'o_id',
                          'o_nota',
                          'o_staff',
                          'o_comp',
                          'o_position'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'o_insert';
  const UPDATED_AT = 'o_update';
}
