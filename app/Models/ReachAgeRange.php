<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReachAgeRange extends Model
{
    use HasFactory;
    protected $table='reach_age_range';

    public function agerange(){
        return $this->belongsTo(ReachIncidence::class,"ageRangeCode","ageRangeCode");
    }
}
