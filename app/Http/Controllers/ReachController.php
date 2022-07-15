<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReachIncidence;
use Illuminate\Support\Facades\DB;

class ReachController extends Controller
{
    //
    public function index()
    {
        // $Incidencia=$this->getIncidencia(["countrycode"=>'AR', "gender"=>"M"]);
        // echo "<pre>"; print_r($Incidencia->toArray());

        // $ProjectedPopulation = $this->getProjectedPopulation(["countrycode" => 'AR', "gender" => "M"]);
        // echo "<pre>";
        // print_r($ProjectedPopulation->toArray());

        $ProjectedPopulation = $this->usagepercentage(["countrycode" => 'AR', "gender" => "M", "product" => 1]);
        echo "<pre>";
        print_r($ProjectedPopulation->toArray());
        exit;
        return view('admin.reach.index');
    }


    public function getIncidencia($filter)
    {

        $countrycode = $filter['countrycode'];
        $gender = $filter['gender'];
        $percentage = ReachIncidence::select('incidence', DB::raw('count(*) as count'))->where('countryCode', $countrycode)->where('gender', $gender)->groupBy('productCode')->get();
        return $percentage;
    }

    public function getProjectedPopulation($filter)
    {
        $countrycode = $filter['countrycode'];
        $gender = $filter['gender'];
        $ProjectedPopulation = ReachIncidence::where('countryCode', $countrycode)->where('gender', $gender)->groupBy('productCode')->selectRaw('sum(connectedPopulation) as sum, sum(incidence) as sumincidence,countryCode,gender,productCode')->get();
        return $ProjectedPopulation;
    }

    public function usagepercentage($filter)
    {
        $product = $filter['product'];
        $countrycode = $filter['countrycode'];
        $gender = $filter['gender'];
        $sumvalues = ReachIncidence::where('countryCode', $countrycode)->where('gender', $gender)->where('productCode', $product)->groupBy('ageRangeCode')->with('agerange')->selectRaw('sum(connectedPopulation) as sum, sum(incidence) as sumincidence,countryCode,gender,productCode, ageRangeCode')->get();
        return $sumvalues;
    }
}
