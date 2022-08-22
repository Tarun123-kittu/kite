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
    public $products;




    public function __construct()
    {
        $this->products =ReachProduct::all();
    }



    public function index()
    {
        $data = new \stdClass();
        $data->products = $this->products;
        $data->ageRanges = ReachAgeRange::all();
        $data->countries = Country::all();
        return response(['message' => "success", 'data' => $data], 200);
    }

    public function abstract(Request $request)
    {

        $query=$request->all();
        // $abstractyoutube = $this->calculate_proyectada('1', ['BR'], ['M', 'F'], ['406']);
        // $abstractyoutube = $this->usebyage('1', ['BR'], ['M', 'F']);
        // return response(['message' => "success", 'data' =>$query], 200);
        $allProducts= $this->products;
        $response=[];
        foreach($allProducts as $product){
            $response['incidencia'][str_replace(' ', '', $product->description)]=$this->calculate_incidencia($product->productCode,$query['country'],$query['gender'], $query['age']);
            $response['poblacion_proyectada'][str_replace(' ', '', $product->description)]=$this->calculate_proyectada($product->productCode,$query['country'],$query['gender'], $query['age']);
            $response['use_as_per_age'][str_replace(' ', '', $product->description)]=$this->usebyage($product->productCode,$query['country'],$query['gender']);
            $response['population_projection_by_age'][str_replace(' ', '', $product->description)]=$this->projectedPopulationbyAge($product->productCode,$query['country'],$query['gender']);
        }
        return response(['message' => "success", 'data' => $response], 200);
    }

    public function reach(Request $request)
    {
        $totalIncidence = ReachIncidence::select(DB::raw("SUM(incidence)*connectedPopulation as incidence , SUM(connectedPopulation) as connectedPopulation"))->first();
        $variables = Variables::first();
        $data = ReachIncidence::select(DB::raw("SUM(connectedPopulation) as connectedPopulation , 
        ROUND((SUM(incidence)*connectedPopulation),2) as incidence , 
        ROUND((SUM(incidence)*connectedPopulation / " . $totalIncidence->incidence . ")*100, 2) as percentage,
        ".ROUND((($request->budget/$variables->cpm)*(1000/$variables->frequency)/$totalIncidence->connectedPopulation)*(100),2)."
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
            'frequency' => 'required|integer',
            'cpm' => 'required|integer',
            
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

    public function calculate_incidencia($product, $country, $gender, $age)
    {
        $allincidences = ReachIncidence::query();
        $countryincidences = ReachIncidence::query();
        $allincidences->where('productCode', $product);
        $countryincidences->where('productCode', $product);
        if (count($country) > 0) {
            $countryincidences->whereIn('countryCode', $country);
        }
        if (count($gender) > 0) {
            $allincidences->whereIn('gender', $gender);
            $countryincidences->whereIn('gender', $gender);
        }
        if (count($age) > 0) {
            $allincidences->whereIn('ageRangeCode', $age);
            $countryincidences->whereIn('ageRangeCode', $age);
        }
        $results = $allincidences->sum('incidence');
        $countryresult = $countryincidences->sum('incidence');
        $percentage = ($countryresult / $results) * 100;
        return $percentage;
    }

    public function calculate_proyectada($product, $country, $gender, $age)
    {
        $connectedpopulation = ReachIncidence::query();
        $incidence = ReachIncidence::query();
        $connectedpopulation->where('productCode', $product);
        $incidence->where('productCode', $product);
        if (count($country) > 0) {
            $connectedpopulation->whereIn('countryCode', $country);
            $incidence->whereIn('countryCode', $country);
        }
        if (count($gender) > 0) {
            $connectedpopulation->whereIn('gender', $gender);
            $incidence->whereIn('gender', $gender);
        }
        if (count($age) > 0) {
            $connectedpopulation->whereIn('ageRangeCode', $age);
            $incidence->whereIn('ageRangeCode', $age);
        }
        $resultcp = $connectedpopulation->sum('connectedPopulation');
        $resulin = $incidence->sum('incidence');
        return $resultcp * $resulin;
    }

    public function usebyage($product, $country, $gender)
    {
        $allproductuse=ReachIncidence::query();
        $filterproduct=ReachIncidence::query();

        $allresult=$allproductuse->selectRaw("Count(productCode) as products, ageRangeCode")->with('agerange')->groupBy('ageRangeCode')->get();
        $filterproduct->selectRaw("Count(productCode) as products, ageRangeCode")->where('productCode',$product);
        if(count($country) > 0){
            $filterproduct->whereIn('countryCode', $country);
        }
        if (count($gender) > 0) {
            $filterproduct->whereIn('gender', $gender);
        }
       $filteredpro= $filterproduct->groupBy('ageRangeCode')->get();

       $result=[];
       if(count($filteredpro)>0){
        foreach($allresult as $index=>$value){
            $filteredindex=array_search($value['ageRangeCode'], (json_decode(json_encode($filteredpro),TRUE)));
            $filteredvalue= $filteredpro[$filteredindex]['products'];
            $percentage=number_format((float)(($filteredvalue/$value['products'])*100), 2, '.', '');
            array_push($result,["name"=>$value["agerange"]["description"], "y"=>$percentage]);  
    }
       }
      // return $filteredpro;
        return stripslashes(json_encode($result));
    }

    public function projectedPopulationbyAge($product, $country, $gender){
        $connectedpopulation = ReachIncidence::query();
        $connectedpopulation->where('productCode', $product);

        if (count($country) > 0) {
            $connectedpopulation->whereIn('countryCode', $country);
        }
        if (count($gender) > 0) {
            $connectedpopulation->whereIn('gender', $gender);
        }
         $result=$connectedpopulation->selectRaw("sum(connectedPopulation) as connectedpop, sum(incidence) as incidencepop, ageRangeCode")->with('agerange')->groupBy('ageRangeCode')->get();
        $response=[];
        foreach($result as $res){
            $response[]=$res->connectedpop+$res->incidencepop;
        }
        
         return stripslashes(json_encode($response));

    }

}
