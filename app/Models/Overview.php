<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Overview extends Model
{
    protected $table='UV_overview';
    protected $fillable = [
        'deal_id','date', 'format', 'bidding_strategy','campaign','plateform','advertiser','impressions','clicks','views','engagements'
    ];
    
}
