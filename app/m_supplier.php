<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_supplier extends Model
{
	protected $table = 'm_supplier';
    protected $primaryKey = 's_id';
    protected $fillable = ['s_id', 
    						's_code',
                            's_company',
                            's_npwp',
                            's_email',  
                            's_address', 
                            's_phone',
                            's_phone1',
                            's_phone2', 
                            's_fax',
                            's_note',
                            's_top',
                            's_isactive',
                          ];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';
}
