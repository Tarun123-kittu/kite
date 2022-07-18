<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Overview;

class ReportsController extends Controller
{
    public function index(Request $request)
    {

        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $month = date('m');
        $seven_days = date('Y-m-d', strtotime("-7 days"));
        $last_month = date("m", strtotime('-1 month'));
        $type = auth()->user()->type;
        if ($type == '1') {

            $data = [
                'overview' => Overview::when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    if ($request->filterDate) {
                        return $query->groupBy($request->filterDate, $request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date , day(date) as byDay , month(date) as byMonth');
                    } else {
                        return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date');
                    }
                })->when($request->filterDate, function ($query) use ($request) {
                    if (!$request->dimension) {
                        if ($request->filterDate == "byDay") {
                            return $query->groupBy('byMonth', 'byDay')->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date , day(date) as byDay , month(date) as byMonth');
                        } else {
                            return $query->groupBy($request->filterDate)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date , day(date) as byDay , month(date) as byMonth');
                        }
                    }
                })
                    ->get(),


                'campaign' => Overview::groupBy('campaign')->selectRaw('campaign')->get(),
                'formats' => Overview::groupBy('format')->selectRaw('format')->get(),
                'advertiser' => Overview::groupBy('advertiser')->selectRaw('advertiser')->get(),

                'cpcv' => Overview::where(function ($query) {
                    $query->where('format', 'Branded Video (AA)')
                        ->orWhere('format', 'Bumper Ads / URL YouTube (KSV)')
                        ->orWhere('format', 'Pre Roll - In stream / URL YouTube (KSV)')
                        ->orWhere('format', 'Pre Roll 30¨ (AA / Programatic)');
                })->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser');
                })->get(),


                'egRate' => Overview::where(function ($query) {
                    $query->where('format', 'Interstitial Tradicional (AA)')
                        ->orWhere('format', 'Interstitial / Carousel (AA)')
                        ->orWhere('format', 'Interstitial / Filmstrip (AA)')
                        ->orWhere('format', 'Interstitial / Minigame (AA)');
                })->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser');
                })->get(),

                'ctr' => Overview::where('format', '!=', 'Virtual OOH - Estático')->where('format', '!=', 'Virtual OOH - GIF')->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser');
                })->get(),


                'impressions' => $request->impressions ?? "",
                'views' => $request->views ?? "",
                'clicks' =>  $request->clicks ?? "",
                'engagements' => $request->engagements ?? "",
                'cpcvs' => $request->cpcv ?? "",
                'ctrs' => $request->ctr ?? "",
                'egRates' => $request->egRate ?? "",
                'dimension' => $request->dimension ?? "",
                'filterDate' => $request->filterDate ?? ""
            ];
        } else {

            $deal = [];
            foreach (auth()->user()->map as $val) {
                array_push($deal, $val->deal_id);
            }

            $data = [
                'overview' => Overview::whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    if ($request->filterDate) {
                        return $query->groupBy($request->filterDate, $request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date , day(date) as byDay , month(date) as byMonth');
                    } else {
                        return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date');
                    }
                })->when($request->filterDate, function ($query) use ($request) {
                    if (!$request->dimension) {
                        if ($request->filterDate == "byDay") {
                            return $query->groupBy('byMonth', 'byDay')->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date , day(date) as byDay , month(date) as byMonth');
                        } else {
                            return $query->groupBy($request->filterDate)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser , format , campaign , date(date) as date , day(date) as byDay , month(date) as byMonth');
                        }
                    }
                })->get(),


                'campaign' => Overview::whereIn('deal_id', $deal)->groupBy('campaign')->selectRaw('campaign')->get(),
                'formats' => Overview::groupBy('format')->selectRaw('format')->get(),
                'advertiser' => Overview::groupBy('advertiser')->selectRaw('advertiser')->get(),

                'cpcv' => Overview::whereIn('deal_id', $deal)->where(function ($query) {
                    $query->where('format', 'Branded Video (AA)')
                        ->orWhere('format', 'Bumper Ads / URL YouTube (KSV)')
                        ->orWhere('format', 'Pre Roll - In stream / URL YouTube (KSV)')
                        ->orWhere('format', 'Pre Roll 30¨ (AA / Programatic)');
                })->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser');
                })->get(),


                'egRate' => Overview::whereIn('deal_id', $deal)->where(function ($query) {
                    $query->where('format', 'Interstitial Tradicional (AA)')
                        ->orWhere('format', 'Interstitial / Carousel (AA)')
                        ->orWhere('format', 'Interstitial / Filmstrip (AA)')
                        ->orWhere('format', 'Interstitial / Minigame (AA)');
                })->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser');
                })->get(),

                'ctr' => Overview::whereIn('deal_id', $deal)->where('format', '!=', 'Virtual OOH - Estático')->where('format', '!=', 'Virtual OOH - GIF')->when($request->creation_date, function ($query) use ($request) {
                    return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                })->when($request->campaign, function ($query) use ($request) {
                    return $query->where('campaign', $request->campaign);
                })->when($request->format, function ($query) use ($request) {
                    return $query->where('format', $request->format);
                })->when($request->advertiser, function ($query) use ($request) {
                    return $query->where('advertiser', $request->advertiser);
                })->when($request->period, function ($query) use ($request, $yesterday, $month, $seven_days, $last_month) {
                    if ($request->period == "yesterday") {
                        return $query->where('date', $yesterday);
                    } elseif ($request->period == "month") {
                        return $query->whereMonth('date', $month);
                    } elseif ($request->period == "seven_days") {
                        return $query->whereBetween('date', [$seven_days, date('y-m-d')]);
                    } else {
                        return $query->whereMonth('date', $last_month);
                    }
                })->when($request->dimension, function ($query) use ($request) {
                    return $query->groupBy($request->dimension)->selectRaw('ifNull(sum(impressions),0) as impressions , ifNull(sum(views),0) as views ,ifNull(sum(clicks),0) as clicks , ifNull(sum(engagements),0) as engagements , advertiser');
                })->get(),


                'impressions' => $request->impressions ?? "",
                'views' => $request->views ?? "",
                'clicks' =>  $request->clicks ?? "",
                'engagements' => $request->engagements ?? "",
                'cpcvs' => $request->cpcv ?? "",
                'ctrs' => $request->ctr ?? "",
                'egRates' => $request->egRate ?? "",
                'dimension' => $request->dimension ?? "",
                'filterDate' => $request->filterDate ?? ""
            ];
        }

        return response(['message' => "success" , 'data' => $data], 200);
        // return view('admin.reports.index', compact('data', 'request'));
    }
}
