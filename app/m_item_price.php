<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_item_price extends Model
{
    protected $table = 'm_item_price';
<<<<<<< HEAD
    protected $primaryKey = null;
    public $incrementing = false;
=======
    protected $primaryKey = 'ip_group';
    protected $fillable = [ 'ip_group', 
                            'ip_item',
                            'ip_price',
                            'ip_edit'
                        ];

    public $incrementing = false;
    public $remember_token = false;
>>>>>>> c5c818f4f7160cdede85f2c93881eb3dfa601014
    public $timestamps = false;
}
