<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Overview;
use App\Models\ReachAgeRange;
use App\Models\ReachIncidence;
use App\Models\ReachProduct;
use App\Models\Variables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CalculatorController extends Controller
{

    public function index()
    {
        $data = new \stdClass();
        $data->products = ReachProduct::all();
        $data->ageRanges = ReachAgeRange::all();
        $data->countries = Country::all();

        return response(['message' => "success", 'data' => $data], 200);
    }

    public function abstract(Request $request)
    {
    }

    public function reach(Request $request)
    {
        $totalIncidence = ReachIncidence::select(DB::raw("SUM(incidence)*connectedPopulation as incidence , SUM(connectedPopulation) as connectedPopulation"))->first();
        $variables = Variables::first();
        $data = ReachIncidence::select(DB::raw("SUM(connectedPopulation) as connectedPopulation , 
        SUM(incidence)*connectedPopulation as incidence , 
        (SUM(incidence)*connectedPopulation / " . $totalIncidence->incidence . ")*100 as percentage,
        ".(($request->budget/$variables->cpm)*(1000/$variables->frequency)/$totalIncidence->connectedPopulation)/(100)."
        as target_population
        "))
            ->when($request->country, function ($query) use ($request) {
                return $query->where('countryCode', $request->country);
            })
            ->when($request->product, function ($query) use ($request) {
                return $query->where('productCode', $request->product);
            })
            ->get();
        return response(['message' => "success", 'data' => $data], 200);
    }

    public function getVariables(){
        return response(['message' => "success", 'data' => Variables::all()], 200);
    }

    public function updateVariables(Request $request , $id){
        $validator = Validator::make($request->all(), [
            'frequency' => 'required',
            'cpm' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response(['message' => "error", 'data' => $validator->errors()->first()], 400);
        }

        $data = Variables::find($id);
        $data->frequency = $request->frequency;
        $data->cpm = $request->cpm;
        $data->save();
        return response(['message' => "success", 'data' => $data], 200);

    }
}
