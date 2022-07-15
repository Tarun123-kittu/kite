<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReachIncidence extends Model
{
    use HasFactory;
    protected $table='reach_incidence';
    public function products(){
        return $this->hasMany("App\Models\ReachProduct","productCode","productCode");
    }

    public function agerange(){
        return $this->belongsTo("App\Models\ReachAgeRange","ageRangeCode","ageRangeCode");
    }

}
