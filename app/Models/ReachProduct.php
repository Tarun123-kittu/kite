<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReachProduct extends Model
{
    use HasFactory;
    protected $table='reach_product';

    public function products(){
        return $this->hasMany(ReachIncidence::class,"productCode","productCode");
    }

    
}
