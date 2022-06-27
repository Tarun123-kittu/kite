<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset as MailPasswordReset;
use App\Models\Device;
use App\Models\Overview;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        return view('admin.auth.login');
    }

    public function dashboard(Request $request)
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $month = date('m');
        $seven_days = date('Y-m-d', strtotime("-7 days"));
        $thirty_days = date('Y-m-d', strtotime("-30 days"));
        $last_month = date("m", strtotime('-1 month'));
        $type = AuthAdmin::user()->type;
        if ($type == '1') {
            if (!empty($request->creation_date || $request->period || $request->campaign || $request->format)) {
                $data = [
                    'overview' => Overview::when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'cpcv' => Overview::when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->where(function ($query) {
                        $query->where('format', 'Branded Video (AA)')
                            ->orWhere('format', 'Bumper Ads / URL YouTube (KSV)')
                            ->orWhere('format', 'Pre Roll - In stream / URL YouTube (KSV)')
                            ->orWhere('format', 'Pre Roll 30¨ (AA / Programatic)');
                    })->get(),


                    'egRate' => Overview::when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->where(function ($query) {
                        $query->where('format', 'Interstitial Tradicional (AA)')
                            ->orWhere('format', 'Interstitial / Carousel (AA)')
                            ->orWhere('format', 'Interstitial / Filmstrip (AA)')
                            ->orWhere('format', 'Interstitial / Minigame (AA)');
                    })->get(),


                    'ctr' => Overview::when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->where('format', '!=', 'Virtual OOH - Estático')->where('format', '!=', 'Virtual OOH - GIF')->get(),


                    'views' => Overview::groupBy('date')->selectRaw('sum(views) as views')->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'impressions' => Overview::groupBy('date')->selectRaw('sum(impressions) as impressions')->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'device' => Device::groupBy('Device')->selectRaw('Device as name , ifnull(sum(impressions),0) as y')->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'format' => Overview::groupBy('format')->selectRaw('format , sum(impressions) as impressions , sum(views) as views , sum(clicks) as clicks , sum(engagements) as engagements')->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'graph' => Overview::groupBy('date')->selectRaw('date(date) as date ,  sum(views) as views , sum(impressions) as impressions')->whereYear('date', date("Y"))->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'formats' => Overview::groupBy('format')->selectRaw('format')->get(),
                    'campaign' => Overview::groupBy('campaign')->selectRaw('campaign')->get(),
                ];
            } else {
                $data = [
                    'overview' => Overview::all(),
                    'cpcv' => Overview::where(function ($query) {
                        $query->where('format', 'Branded Video (AA)')
                            ->orWhere('format', 'Bumper Ads / URL YouTube (KSV)')
                            ->orWhere('format', 'Pre Roll - In stream / URL YouTube (KSV)')
                            ->orWhere('format', 'Pre Roll 30¨ (AA / Programatic)');
                    })->get(),
                    'egRate' => Overview::where(function ($query) {
                        $query->where('format', 'Interstitial Tradicional (AA)')
                            ->orWhere('format', 'Interstitial / Carousel (AA)')
                            ->orWhere('format', 'Interstitial / Filmstrip (AA)')
                            ->orWhere('format', 'Interstitial / Minigame (AA)');
                    })->get(),
                    'ctr' => Overview::where('format', '!=', 'Virtual OOH - Estático')->where('format', '!=', 'Virtual OOH - GIF')->get(),
                    'views' => Overview::groupBy('date')->selectRaw('sum(views) as views')->get(),
                    'impressions' => Overview::groupBy('date')->selectRaw('sum(impressions) as impressions')->get(),
                    'device' => Device::groupBy('Device')->selectRaw('Device as name , ifnull(sum(impressions),0) as y')->get(),
                    'format' => Overview::groupBy('format')->selectRaw('format , sum(impressions) as impressions , sum(views) as views , sum(clicks) as clicks , sum(engagements) as engagements')->get(),
                    // 'graph' => Overview::groupBy('month')->selectRaw('month(date) as month ,  sum(views) as views , sum(impressions) as impressions')->whereYear('date', date("Y"))->get(),
                    'graph' => Overview::groupBy('date')->selectRaw('date(date) as date,  ifnull(sum(views),0) as views , ifnull(sum(impressions),0) as impressions')->whereBetween('date', [$thirty_days, date('Y-m-d')])->get(),
                    'formats' => Overview::groupBy('format')->selectRaw('format')->get(),
                    'campaign' => Overview::groupBy('campaign')->selectRaw('campaign')->get(),
                ];
            }
        } else {
            $deal = [];
            foreach (AuthAdmin::user()->map as $val) {
                array_push($deal, $val->deal_id);
            }
            if (!empty($request->creation_date || $request->period || $request->campaign || $request->format)) {
                $data = [
                    'overview' => Overview::whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


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
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
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
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'ctr' => Overview::whereIn('deal_id', $deal)->where('format', '!=', 'Virtual OOH - Estático')->where('format', '!=', 'Virtual OOH - GIF')->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),

                    'views' => Overview::groupBy('date')->selectRaw('sum(views) as views')->whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'impressions' => Overview::groupBy('date')->selectRaw('sum(impressions) as impressions')->whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),


                    'device' => Device::groupBy('Device')->selectRaw('Device as name , ifnull(sum(impressions),0) as y')->whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),

                    'format' => Overview::groupBy('format')->selectRaw('format , sum(impressions) as impressions , sum(views) as views , sum(clicks) as clicks , sum(engagements) as engagements')->whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),

                    'graph' => Overview::groupBy('date')->selectRaw('date(date) as date ,  sum(views) as views , sum(impressions) as impressions')->whereYear('date', date("Y"))->whereIn('deal_id', $deal)->when($request->creation_date, function ($query) use ($request) {
                        return $query->whereBetween('date', [$request->startDate, $request->endDate]);
                    })->when($request->campaign, function ($query) use ($request) {
                        return $query->where('campaign', $request->campaign);
                    })->when($request->format, function ($query) use ($request) {
                        return $query->where('format', $request->format);
                    })->when($request->period, function ($query) use ($request , $yesterday , $month , $seven_days , $last_month) {
                        if ($request->period == "yesterday") {
                            return $query->where('date', $yesterday);
                        }elseif($request->period == "month"){
                            return $query->whereMonth('date',$month);
                        }elseif($request->period == "seven_days"){
                            return $query->whereBetween('date',[$seven_days , date('y-m-d')]);
                        }else{
                            return $query->whereMonth('date',$last_month);
                        }
                    })->get(),

                    'formats' => Overview::groupBy('format')->selectRaw('format')->get(),
                    'campaign' => Overview::groupBy('campaign')->selectRaw('campaign')->get(),

                ];
            } else {
                $data = [
                    'overview' => Overview::whereIn('deal_id', $deal)->get(),
                    'cpcv' => Overview::whereIn('deal_id', $deal)->where(function ($query) {
                        $query->where('format', 'Branded Video (AA)')
                            ->orWhere('format', 'Bumper Ads / URL YouTube (KSV)')
                            ->orWhere('format', 'Pre Roll - In stream / URL YouTube (KSV)')
                            ->orWhere('format', 'Pre Roll 30¨ (AA / Programatic)');
                    })->get(),
                    'egRate' => Overview::whereIn('deal_id', $deal)->where(function ($query) {
                        $query->where('format', 'Interstitial Tradicional (AA)')
                            ->orWhere('format', 'Interstitial / Carousel (AA)')
                            ->orWhere('format', 'Interstitial / Filmstrip (AA)')
                            ->orWhere('format', 'Interstitial / Minigame (AA)');
                    })->get(),
                    'ctr' => Overview::whereIn('deal_id', $deal)->where('format', '!=', 'Virtual OOH - Estático')->where('format', '!=', 'Virtual OOH - GIF')->get(),
                    'views' => Overview::groupBy('date')->selectRaw('sum(views) as views')->whereIn('deal_id', $deal)->get(),
                    'impressions' => Overview::groupBy('date')->selectRaw('sum(impressions) as impressions')->whereIn('deal_id', $deal)->get(),
                    'device' => Device::groupBy('Device')->selectRaw('Device as name , ifnull(sum(impressions),0) as y')->whereIn('deal_id', $deal)->get(),
                    'format' => Overview::groupBy('format')->selectRaw('format , sum(impressions) as impressions , sum(views) as views , sum(clicks) as clicks , sum(engagements) as engagements')->whereIn('deal_id', $deal)->get(),
                    // 'graph' => Overview::groupBy('month')->selectRaw('month(date) as month ,  sum(views) as views , sum(impressions) as impressions')->whereYear('date', date("Y"))->whereIn('deal_id', $deal)->get(),
                    'graph' => Overview::groupBy('date')->selectRaw('date(date) as date,  ifnull(sum(views),0) as views , ifnull(sum(impressions),0) as impressions')->whereBetween('date', [$thirty_days, date('Y-m-d')])->whereIn('deal_id', $deal)->get(),
                    'formats' => Overview::groupBy('format')->selectRaw('format')->get(),
                    'campaign' => Overview::groupBy('campaign')->selectRaw('campaign')->get(),

                ];
            }
        }

        return view('admin.dashboard', compact('data','request'));
    }

    public function login(Request $request)
    {

        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($data->fails()) {
            return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => $data->errors()->first()], 'show.login', 400);
        }

        $admin = User::where("email", $request->email)->first();
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => "Invalid Password"], 'show.login', 400);
            }

            AuthAdmin::login($admin);
            return Helpers::response(['ajax' => $request->ajax(), 'status' => 'success', 'message' => "Login Successful"], 'dashboard', 200);
        } else {
            return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => "Invalid Email/Password"], 'show.login', 400);
        }
    }

    public function logout(Request $request)
    {
        AuthAdmin::logout();
        return $request->ajax() ?
            response(['status' => 'success', 'message' => 'Logout Successful'], 200) :
            redirect()->route('show.login')->with('success', 'Logout Successful');
    }

    public function showForgotPassword()
    {
        return view('admin.auth.forgot');
    }

    public function forgotPassword(Request $request)
    {

        $admin = User::where('email', $request->email)->first();
        if ($admin) {
            $admin->password_token = Str::random(30);
            $admin->save();
            Mail::to($request->email)->send(new MailPasswordReset($admin));
            return Helpers::success(['message' => "Password Reset Link Sent"], 'show.login', 200);
        } else {
            return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => "No User Found"], 'show.forgot-password', 404);
        }
    }

    public function request(Request $request, $email, $hash)
    {

        $passwordLink = User::where('email', $email)->where('password_token', $hash)->first();
        if ($passwordLink) {
            return view('admin.auth.reset-password', compact('passwordLink', 'email', 'hash'));
        } else {
            return redirect()->route('show.login')->with('notification', ['status' => 'error', 'message' => 'Invalid Request!']);
        }
    }

    public function resetPassword(Request $request, $email, $hash)
    {
        $data = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ]);

        if ($data->fails()) {
            return redirect()->back()->with('notification', ['status' => 'error', 'message' => $data->errors()->first()]);
        }
        if ($email == $request->email && $hash == $request->hash) {
            $passwordLink = User::where('email', $email)->where('password_token', $hash)->first();
            if ($passwordLink) {
                $passwordLink->password = Hash::make($request->password);
                $passwordLink->save();
                return Helpers::success(['message' => "Password Reset Successfully"], 'show.login', 200);
            } else {
                return redirect()->route('show.login')->with('notification', ['status' => 'error', 'message' => 'Invalid Request']);
            }
        } else {
            return redirect()->route('show.login')->with('notification', ['status' => 'error', 'message' => 'Invalid Request']);
        }
    }

    public function profile()
    {
        return view("admin.profile.profile");
    }

    public function update(Request $request)
    {
        $data = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'required',
            'email' => 'required|unique:RD_users,email,' . AuthAdmin::user()->id,

        ]);

        if ($data->fails()) {
            return Helpers::response(['ajax' => $request->ajax(), 'status' => 'error', 'message' => $data->errors()->first()], 'show.profile', 400);
        }

        $admin = User::find(AuthAdmin::user()->id);

        if ($admin) {
            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->company = $request->company;
            $admin->email = $request->email;
            $admin->save();
            return Helpers::success(['message' => "Profile Updated"], 'show.profile', 200);
        } else {
            return Helpers::failure(['message' => "Profile Updated"], 'show.profile', 400);
        }
    }

    public function changePassword()
    {
        return view("admin.auth.changepassword");
    }

    public function updatePassword(Request $request)
    {
        $data = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if ($data->fails()) {
            return Helpers::failure(['message' => $data->errors()->first()], 'show.profile', 400);
        }

        $admin = User::where("email", AuthAdmin::user()->email)->first();
        if ($admin) {
            if (!Hash::check($request->password, $admin->password)) {
                return Helpers::failure(['message' => "Current Password Didn't Match"], 'admin.changepassword', 400);
            }

            $admin->password = Hash::make($request->new_password);
            $admin->save();
            return Helpers::success(['message' => "Password Updated"], 'admin.changepassword', 200);
        }
    }
}
