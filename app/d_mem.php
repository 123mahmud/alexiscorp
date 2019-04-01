<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mem extends Model
{
    protected $table = 'd_mem';
    protected $primaryKey = 'm_id';
    protected $fillable = ['m_id',
                          'm_pegawai_id',
                          'm_username',
                          'm_passwd',
                          'm_name',
                          'm_birth_tgl',
                          'm_addr',
                          'm_reff',
                          'm_lastlogin',
                          'm_lastlogout',
                          'm_insert',
                          'm_update'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    public function getPegawaiMan()
    {
      return $this->belongsTo('App\m_pegawai_man', 'm_pegawai_id', 'c_id');
    }
}
