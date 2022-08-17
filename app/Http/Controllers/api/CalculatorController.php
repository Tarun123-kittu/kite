<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Overview;
use App\Models\ReachAgeRange;
use App\Models\ReachProduct;

class CalculatorController extends Controller
{

    public function index(){
        $data = new \stdClass();
        $data->products = ReachProduct::all();
        $data->ageRanges = ReachAgeRange::all();
        
        return response(['message' => "success" , 'data' => $data], 200);
    }
    
    public function abstract(Request $request)
    {

    }

    public function reach(Request $request)
    {

    }
}