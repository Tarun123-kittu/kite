<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserMap extends Model
{
    protected $table='RD_users_mp';
    
    protected $fillable = [
       'user_id','deal_id'
    ];
    public $timestamps = false;

    public function overview(){
        return $this->hasMany('App\Models\Overview','deal_id','deal_id');
    }
}
